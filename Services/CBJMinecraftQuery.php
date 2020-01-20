<?php
/**
 * Created by PhpStorm.
 * User: CodingByJerez
 * Url: http://coding.by.jerez.me
 * Github: https://github.com/CodingByJerez
 * Date: 28/10/2019
 * Time: 13:37
 * Help by https://github.com/xPaw/PHP-Minecraft-Query
 */

namespace CodingByJerez\MinecraftBundle\Services;

use CodingByJerez\MinecraftBundle\Exception\MinecraftException;
use CodingByJerez\MinecraftBundle\Model\Joueurs;
use CodingByJerez\MinecraftBundle\Model\ServeurStatus;
use CodingByJerez\MinecraftBundle\Model\Version;
use Symfony\Contracts\Translation\TranslatorInterface;


class CBJMinecraftQuery extends CBJAbstractMinecraft
{
    private $host;
    private $port;
    private $timeout;

    private $socket;

    private $result;

    /**
     * ServeurStatus constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        parent::__construct($translator);

        return $this;
    }

    /**
     * @return ServeurStatus
     */
    public function getStatus(): ServeurStatus
    {
        return $this->result;
    }


    /**
     * @param string $host
     * @param int $port
     * @param int $timeout
     * @return MinecraftQuery
     * @throws MinecraftException
     */
    public function query(string $host = '127.0.0.1', int $port = 25565, int $timeout = 3): self
    {
       // self::$versions = is_null(self::$versions) ? Config::getInstance()->get("version") : self::$versions;
        $this->timeout = $timeout;
        $this->port = $port ?? 25565;
        if(!$this->resolveSRV($host) || empty($this->host))
            $this->host = filter_var($host, FILTER_VALIDATE_IP) ? $host : gethostbyname($host);

        return $this->connect();
    }

    /**
     * @param $host
     * @return bool
     */
    private function resolveSRV($host): bool
    {
        if(ip2long($host) !== false)
            return false;
        $Record = dns_get_record( '_minecraft._tcp.' . $host, DNS_SRV );
        if(empty($Record))
            return false;
        if(isset($Record[0]['target']))
            $this->host = $Record[0]['target'];
        if( isset( $Record[ 0 ][ 'port' ] ) )
            $this->port = $Record[0]['port'];

        return true;
    }


    /**
     * @return MinecraftQuery
     * @throws MinecraftException
     */
    private function connect(): self
    {
        $this->socket = @fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);
        if(!$this->socket){
            throw new MinecraftException($this->trans("exception.failed_to_connect") . "$errno ($errstr)");
        }
        // Set Read/Write timeout
        stream_set_timeout($this->socket, $this->timeout);

        return $this->queryServer();
    }


    /**
     * @return MinecraftQuery
     * @throws MinecraftException
     */
    private function queryServer(): self
    {
        $this->result = new ServeurStatus();

        $TimeStart = microtime(true);
        // See http://wiki.vg/Protocol (Status Ping)
        $Data = "\x00";
        $Data .= "\x04";
        $Data .= pack('c', strlen($this->host)) . $this->host;
        $Data .= pack('n', $this->port);
        $Data .= "\x01";
        $Data = pack('c', strlen($Data)) . $Data;
        fwrite($this->socket, $Data); // handshake
        fwrite($this->socket, "\x01\x00");

        $Length = $this->readVarInt();

        if($Length < 10)
           return $this;

        fgetc($this->socket);
        $Length = $this->readVarInt();
        $Data = "";
        do{
            if (microtime(true) - $TimeStart > $this->timeout)
                throw new MinecraftException($this->trans("exception.timed_out"));

            $Remainder = $Length - strlen($Data);
            $block = fread($this->socket, $Remainder);
            if (!$block)
                throw new MinecraftException($this->trans("exception.few_data"));

            $Data .= $block;
        }while(strlen($Data) < $Length);

        if($Data === false)
            throw new MinecraftException($this->trans("exception.any_data"));


        $Data = json_decode($Data);

        if(json_last_error() !== JSON_ERROR_NONE){
            if(function_exists('json_last_error_msg'))
                throw new MinecraftException(json_last_error_msg());
            else
                throw new MinecraftException($this->trans("exception.parsing_failed"));

        }

        $this->result
            ->setOnline(true)
            ->setVersion(new Version($Data->version))
            ->setJoueurs(new Joueurs($Data->players))
            ->setFavicon($Data->favicon)
            ->setDescription($Data->description)
        ;

        return $this;
    }


    /**
     * @return int
     * @throws MinecraftException
     */
    private function ReadVarInt(): int
    {
        $i = 0;
        $j = 0;
        while(true){
            $k = @fgetc($this->socket);
            if($k === FALSE){
                return 0;
            }
            $k = ord( $k );
            $i |= ( $k & 0x7F ) << $j++ * 7;
            if($j > 5){
                throw new MinecraftException($this->trans("exception.var_int_too_big"));
            }
            if( ( $k & 0x80 ) != 128 ) {
                break;
            }
        }
        return $i;
    }


    /**
     *
     */
    private function close(): void
    {
        if($this->socket !== null){
            @fclose($this->socket);
            $this->socket = null;
        }
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->close();
    }


}