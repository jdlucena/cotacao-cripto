<?php

class Binance extends Conexao
{
    private $dados;
    private $ultimo_preco;
    private $preco_medio;
    private $novo_preco_medio;
    public $status = false;

    public function __construct()
    {
        // Se tiver clicado no botão Enviar
        if (isset($_POST["cadastrar"])) {

            // Se foi selecionado alguma criptomoeda
            if (isset($_POST["symbol"]) && count($_POST["symbol"]) > 0) {

                // Passa as moedas selecionadas
                $this->saveBidPriceOnDataBase($_POST["symbol"]);
            } else {
                $this->errors[] = "Nenhuma moeda selecionada";
            }
        }
    }

    // Função que lista todas as criptomoedas para o select
    public function allCriptomoedas()
    {
        // Endereço da API com todas as moedas seleciondas
        $endereco_todas_as_moedas = "https://api.binance.com/api/v3/ticker/price";

        // Lê todo o conteúdo e armazena na string
        $dados_todas_as_moedas = file_get_contents($endereco_todas_as_moedas);

        // Decodifica a string JSON
        $json_todas_as_moedas = json_decode($dados_todas_as_moedas, true);

        // Retorna resultado
        return $json_todas_as_moedas;
    }

    // Função que grava e consulta preço das criptomoedas
    private function saveBidPriceOnDataBase($valores)
    {
        /**
         * Formatação padrão aceito pela API BINANCE:
         * ["BTCUSDT","BNBUSDT"]
         * 
         * Para mais informações:
         * @see https://binance-docs.github.io/apidocs/spot/en/#24hr-ticker-price-change-statistics
         */
        for ($i = 0; $i < count($_POST["symbol"]); $i++) {
            ($i == 0) ? $this->dados .= '"' . $_POST["symbol"][$i] . '"' : $this->dados .= ',"' . $_POST["symbol"][$i] . '"';
        }

        // endereço da API com as moedas seleciondas
        $endereco_moedas_selecionadas = "https://api.binance.com/api/v3/ticker/price?symbols=[$this->dados]";

        // Lê todo o conteúdo e armazena na string
        $dados_moedas_selecionadas = file_get_contents($endereco_moedas_selecionadas);

        // Decodifica a string JSON
        $json_moedas_selecionadas = json_decode($dados_moedas_selecionadas, true);

        // Percorre array com as moedas seleciondas
        foreach ($json_moedas_selecionadas as $value) {

            // Chama função para gravar dados no banco
            $this->gravarDados($value['symbol'], $value['price']);

            // Chama função para consultar dados no banco
            $this->consultaPreco($value['symbol']);
        }

        // Retorna mensagem
        $this->messages[] = "Registros inseridos no banco de dados";

        // Altera status para exibir o resultado
        $this->status = true;
    }

    // Função que grava dados no banco
    private function gravarDados($nome, $preco)
    {
        // Verifica se tem conexão com o banco
        if (parent::__construct()) {

            // gravando dados no banco MySQL
            $query_grava_dados = $this->db_mysql->prepare("INSERT INTO `price` (`symbol`, `price`) VALUES (:symbol, :price);");
            $query_grava_dados->bindValue(':symbol', trim($nome), PDO::PARAM_STR);
            $query_grava_dados->bindValue(':price', trim($preco), PDO::PARAM_STR);
            $query_grava_dados->execute();
        }
    }

    // Função que consulta último preço e preço médio no banco de dados
    private function consultaPreco($nome)
    {
        // Verifica se tem conexão com o banco
        if (parent::__construct()) {

            // consulta dados no banco MySQL
            $query_consulta_preco = $this->db_mysql->prepare("SELECT t2.symbol, t2.price, t2.precoMedio from ( SELECT id, symbol, price, ( SELECT avg(t1.price) from ( SELECT * from price where symbol = :symbol order by id desc limit 100 ) t1 ) as precoMedio from price where symbol = :symbol order by id desc limit 1 ) t2");
            $query_consulta_preco->bindValue(':symbol', trim($nome), PDO::PARAM_STR);
            $query_consulta_preco->execute();

            // verifica se retornou algum valor
            if ($query_consulta_preco->rowCount()) {

                // armazena o resultado como objeto
                while ($res_consulta_preco = $query_consulta_preco->fetchObject()) {
                    $this->result_consulta_preco[] = $res_consulta_preco;
                }
            } else {
                $this->errors[] = "Nenhum resultado encontrado";
            }
        }
    }

    // Função para informar se o preço (último) está menor do que 0.5% do que o preço médio
    public function checkAvgBigPrice($ultimo_preco, $preco_medio)
    {
        // armazena valores informados
        $this->ultimo_preco = $ultimo_preco;
        $this->preco_medio = $preco_medio;

        // reduz 0,5% do preço médio
        $this->novo_preco_medio = $this->preco_medio - ($this->preco_medio * 0.005);

        // verificação se último preço é menor que o preço médio
        return ($this->ultimo_preco < $this->novo_preco_medio) ? "<li class='mt-3 alert alert-danger'>Último preço 0,5% menor que o preço médio</li>" : "<li class='mt-3 alert'>&nbsp;<br>&nbsp;</li>";
    }
}
