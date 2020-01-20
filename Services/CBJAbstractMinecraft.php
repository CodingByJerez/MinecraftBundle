<?php
/**
 * Created by PhpStorm.
 * User: CodingByJerez
 * Url: http://coding.by.jerez.me
 * Github: https://github.com/CodingByJerez
 * Date: 28/10/2019
 * Time: 20:12
 */

namespace CodingByJerez\MinecraftBundle\Services;


use Symfony\Contracts\Translation\TranslatorInterface;

class CBJAbstractMinecraft
{

    protected $translator;


    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }


    protected function trans($id, $args = []): string
    {
        return $this->translator->trans($id, $args, "cbj_minecraft");
    }

}