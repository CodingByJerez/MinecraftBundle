=============================
Démarrer avec MinecraftBundle
=============================


Prérequis
---------
Cette version du bundle nécessite Symfony 4.3+


Installation
------------

L'installation est un processus rapide (c'est promis!) En 3 étapes:

1. Télécharger MinecraftBundle en utilisant composer
2. Activer le bundle
3. Configurez MinecraftBundle

Étape 1: Télécharger MinecraftBundle en utilisant composer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Require the bundle with composer:

.. code-block:: bash

    $ composer require codingbyjerez/minecraft-bundle

Composer installera le paquet dans le répertoire ``vendor/codingbyjerez/minecraft-bundle`` de votre projet.

Step 2: Activer le bundle
~~~~~~~~~~~~~~~~~~~~~~~~~

Enable the bundle in the kernel:

.. code-block:: php

    <?php
    // config/Bundles.php

    return [
        // ...
        CodingByJerez\MinecraftBundle\MinecraftBundle::class => ['all' => true],
        // ...
    ];



Step 3: Configurez MinecraftBundle
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


Ajoutez la configuration suivante à votre fichier ``CSS``


.. code-block:: html

    .minecraft.bold {
      font-weight: bold; }
    .minecraft.strikethrough {
      text-decoration: line-through; }
    .minecraft.underline {
      text-decoration: underline; }
    .minecraft.italic {
      font-style: italic; }
    .minecraft.black {
      color: #000000; }
    .minecraft.dark_blue {
      color: #0000AA; }
    .minecraft.dark_green {
      color: #00AA00; }
    .minecraft.dark_aqua {
      color: #00AAAA; }
    .minecraft.dark_red {
      color: #AA0000; }
    .minecraft.dark_purple {
      color: #AA00AA; }
    .minecraft.gold {
      color: #FFAA00; }
    .minecraft.gray {
      color: #AAAAAA; }
    .minecraft.dark_gray {
      color: #555555; }
    .minecraft.blue {
      color: #5555FF; }
    .minecraft.green {
      color: #55FF55; }
    .minecraft.aqua {
      color: #55FFFF; }
    .minecraft.red {
      color: #FF5555; }
    .minecraft.light_purple {
      color: #FF55FF; }
    .minecraft.yellow {
      color: #FFFF55; }
    .minecraft.white {
      color: #FFFFFF; }


Exemples d'utilisation:
-----------------------

.. code-block:: php

    <?php
    // App\Controller\ExempleController.php

    // use CodingByJerez\MinecraftBundle\Exception\MinecraftException;
    // use CodingByJerez\MinecraftBundle\Services\CBJCBJMinecraftQuery;

    public function rechercheAction(CBJMinecraftQuery $serveur)
    {
        try{
            $result = $serveur
                ->query("play.my-serveur.fr", 25565, 3) #<host[default=127.0.0.1]>, <port[default=25565]>, <Time Out[default=3]>
                ->getStatus()
            ;
        }catch (MinecraftException $e){
            echo $e->getMessage();

        }

    }
