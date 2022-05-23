<?php

require_once('config/banco.php');

require_once('classes/Conexao.php');

require_once('classes/Binance.php');

$binance = new Binance();

require_once('views/index.php');