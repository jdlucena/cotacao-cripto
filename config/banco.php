<?php

/**
 * Configuração do banco de dados
 * local onde as constantes estão salvas
 *
 * Para mais informações:
 * @see http://php.net/manual/en/function.define.php
 * @see http://stackoverflow.com/q/2447791/1114320
 *
 * DB_HOST: local do banco de dados
 * DB_NAME: nome do banco de dados
 * DB_USER: usuário com direitos para SELECT, UPDATE, DELETE and INSERT. Criar usuário, não colocar root
 * DB_PASS: senha do usuário
 */

// dados do banco MySql
define("DM_HOST", "localhost");
define("DM_NAME", "binance");
define("DM_USER", "root");
define("DM_PASS", "");

/**
 * Não exibir os erros em produção
 */
#ini_set('display_errors', 0);
#error_reporting(0);