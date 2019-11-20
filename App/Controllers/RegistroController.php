<?php

namespace App\Controllers;
use App\Lib\Sessao;
use App\Models\BO\RegistroBO;
use App\Models\Entidades\Registro;
use App\Models\BO\VeiculoBO;
use App\Models\Entidades\Veiculo;

class RegistroController extends Controller{
    public function entrada(){
        $this->validaUsuario(60*60*6);
        $this->nivelAcesso(4);
                
        $this->render('registro/entrada');
    }
    
    public function listarAutoComplete() {
        $this->validaUsuario();
        $this->nivelAcesso(4);

        $bo = new RegistroBO();

        $tabela = Veiculo::TABELA;
        $campos = ['*', 'date_format(cadastro, "%d/%m/%Y %H:%i:%s") as cadastro'];
        $quantidade = null;
        $pagina = null;

        $condicao = '';
        $valorCondicao = [];

        $orderBy = "placa";
        $debug = null;

        $registro = $bo->listarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
        $placas = [];
        foreach ($registro as $item){
            $placas[$item['placa']] = null;
        }
        
        echo json_encode($placas);                
    }
    
    public function listarRegistrosAcesso() {
        $this->validaUsuario();
        $this->nivelAcesso(4);

        $bo = new RegistroBO();
        
        $tabela = Registro::TABELA . ' r inner join ' . Veiculo::TABELA . ' v on r.veiculo_id = v.id';
        $campos = ['r.id', 'v.id as veiculo_id', 'v.placa', 'date_format(r.entrada, "%d/%m %H:%i") as entrada'];
        $quantidade = null;
        $pagina = null;
        
        $condicao = 'r.status = ?';
        $valorCondicao = [2];

        $orderBy = "r.id asc";
        $debug = null;

        $lista = $bo->listarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
        
        $tabela = Registro::TABELA;
        $campos = ['count(id) as total'];
        $quantidade = 1;
        $pagina = null;
        
        $condicao = 'date(entrada) = date(now())';
        $valorCondicao = [];

        $orderBy = null;
        $debug = null;

        $quant = $bo->selecionarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
        
        $retorno = [
            'registro' => $lista,
            'totalHoje' => $quant['total'] 
        ];
        
        echo json_encode($retorno);

    }
    
    public function novaEntrada() {
        $this->validaUsuario();
        $this->nivelAcesso(4);

        $vetor = $_POST;
        
        if(trim($vetor['placa']) != ''){
            $bo = new RegistroBO();
            $veiculoBO = new VeiculoBO();


            $tabela = Veiculo::TABELA;            

            $veiculo = $veiculoBO->selecionarVetor($tabela, ['*'], 1, null, "placa = '?'", [$vetor['placa']], null);
            if($veiculo){
                
                $tabela = Registro::TABELA;            

                $status = $bo->selecionarVetor($tabela, ['*'], 1, null, "veiculo_id = ? and status = ?", [$veiculo['id'], 2], null);

                if($status){
                    $retorno = [
                        "status" => 0,
                        "msg" => "O veiculo já se encontra no campus.<br>Impossível dar uma nova entrada!"
                    ];            

                    echo json_encode($retorno);                                

                    exit();
                }

                $veiculo_id = $veiculo['id'];
            } else {
                $placa = $vetor['placa'];
                
                $placa = explode("-", $placa);
                
                if(!ctype_alpha($placa[0]) or !is_numeric($placa[1]) or strlen($placa[0]) != 3 or strlen($placa[1]) != 4){
                    $retorno = [
                        "status" => 0,
                        "msg" => "Formato da placa não é válido!"
                    ];

                    echo json_encode($retorno);                                

                    exit();                    
                } else {
                    $placa = strtoupper($placa[0]) ."-". $placa[1];
                }
                
                $dados = [
                    "placa" => $placa,
                    "cadastro" => date('Y-m-d H:i:s')
                ];                
                $validacao = Veiculo::OBRIGATORIO;

                $veiculo_id = $veiculoBO->inserir($tabela, $dados, $validacao);

                if(!$veiculo_id){
                    $retorno = [
                        "status" => 0,
                        "msg" => "Falha ao inserir veiculo!"
                    ];            

                    echo json_encode($retorno);                                

                    exit();
                } else {
                    $info = [
                        'tipo' => 1,
                        'tabela' => Veiculo::TABELA,
                        'campos' => $dados,
                        'descricao' => 'O '.Sessao::getUsuario('tipo_usuario').' [nome], efetuou o cadastro de um novo veículo no sistema.'
                    ];

                    $this->inserirAuditoria($info);

                    $veiculo_id_inserido = $veiculo_id;
                }
            }

            $tabela = Registro::TABELA;
            $dados = [
                "usuario_id" => Sessao::getUsuario('id'),
                "veiculo_id" => $veiculo_id,
                "entrada" => date('Y-m-d H:i:s'),
                "condutor" => $vetor['condutor'],
                "motivo" => $vetor['motivo'],
                "status" => 2
            ];

            $validacao = Registro::OBRIGATORIO;

            $id = $bo->inserir($tabela, $dados, $validacao);

            if($id){
                $info = [
                    'tipo' => 7,
                    'tabela' => Registro::TABELA,
                    'campos' => $dados,
                    'descricao' => 'O '.Sessao::getUsuario('tipo_usuario').' [nome], efetuou o cadastro de uma nova entrada no sistema.'
                ];

                $this->inserirAuditoria($info);

                
                $retorno = [
                    "status" => 1,
                    "msg" => "Registro inserido!",
                    "veiculo_id" => $veiculo_id_inserido
                ];
            } else {
                $retorno = [
                    "status" => 0,
                    "msg" => "Falha ao inserir registro!"
                ];
            }
        } else {
            $retorno = [
                "status" => 0,
                "msg" => "Preencha a placa do veiculo!"
            ];            
        }
        
        echo json_encode($retorno); 
    }
        
    function cancelarRegistro() {
        $this->validaUsuario();
        $this->nivelAcesso(4);

        if($_POST['id']){
            $bo = new RegistroBO();
            $tabela = Registro::TABELA;
            $dados = [
                'status' => 0
            ];
            $condicao = "id = ?";
            $valorCondicao = [$_POST['id']];
            $quantidade = 1;
            $validacao = [];
            $resposta = $bo->update($tabela, $dados, $condicao, $valorCondicao, $quantidade, $validacao);
            
            if($resposta){
                $info = [
                    'tipo' => 9,
                    'tabela' => Registro::TABELA,
                    'campos' => $dados,
                    'descricao' => 'O '.Sessao::getUsuario('tipo_usuario').' [nome], efetuou o cancelamento de uma entrada no sistema.'
                ];

                $this->inserirAuditoria($info);

                $retorno = [
                    "status" => 1,
                    "msg" => "Entrada cancelada!"
                ];            
            } else {
                $retorno = [
                    "status" => 0,
                    "msg" => "Falha ao cancelar entrada!"
                ];                            
            }
        } else {
            $retorno = [
                "status" => 0,
                "msg" => "Acesso incorreto!"
            ];            
        }

        echo json_encode($retorno); 
    }
        
    function confirmarSaidaRegistro() {
        $this->validaUsuario();
        $this->nivelAcesso(4);

        if($_POST['id']){
            $bo = new RegistroBO();
            $tabela = Registro::TABELA;
            $dados = [
                'status' => 1,
                'saida' => date('Y-m-d H:i:s')
            ];
            $condicao = "id = ?";
            $valorCondicao = [$_POST['id']];
            $quantidade = 1;
            $validacao = [];
            $resposta = $bo->update($tabela, $dados, $condicao, $valorCondicao, $quantidade, $validacao);
            
            if($resposta){
                $info = [
                    'tipo' => 8,
                    'tabela' => Veiculo::TABELA,
                    'campos' => $dados,
                    'descricao' => 'O '.Sessao::getUsuario('tipo_usuario').' [nome], efetuou a saída de um veículo no sistema.'
                ];

                $this->inserirAuditoria($info);

                $retorno = [
                    "status" => 1,
                    "msg" => "Saída confirmada!"
                ];            
            } else {
                $retorno = [
                    "status" => 0,
                    "msg" => "Falha ao confirmar saída!"
                ];                            
            }
        } else {
            $retorno = [
                "status" => 0,
                "msg" => "Acesso incorreto!"
            ];            
        }

        echo json_encode($retorno); 
    }
    
    function verRegistro() {
        $this->validaUsuario();
        $this->nivelAcesso(4);

        if($_POST['id']){
            $bo = new RegistroBO();

            $tabela = Registro::TABELA . ' r inner join ' . Veiculo::TABELA . ' v on r.veiculo_id = v.id';
            $campos = ['*', 'r.id', 'date_format(r.entrada, "%d/%m/%Y %H:%i:%s") as entrada', 'date_format(r.saida, "%d/%m/%Y %H:%i:%s") as saida', 'date_format(v.cadastro, "%d/%m/%Y %H:%i:%s") as cadastro', '&&case when status = 2 then "Presente" else "Outros" end as status', '&&case when motivo = 1 then "Não informado" when motivo = 2 then "Aluno(a)" when motivo = 3 then "Transporte escolar" when motivo = 4 then "Professor(a)" when motivo = 5 then "Responsável por aluno" when motivo = 6 then "Visita" else "Evento" end as motivo', '&&case when tipo = 1 then "Motocicleta" when tipo = 2 then "Carros"  when tipo = 3 then "Van/Ônibus" else "Outros" end as tipo'];
            $quantidade = 1;
            $pagina = null;

            $condicao = 'r.id = ?';
            $valorCondicao = [$_POST['id']];

            $orderBy = "";
            $debug = null;

            $registro = $bo->selecionarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
        } else {
            $registro = [];
        }

        echo json_encode($registro);
    }
    
    function infoVeiculo() {
        $this->validaUsuario();
        $this->nivelAcesso(4);

        if($_POST['id']){
            $bo = new RegistroBO();

            $tabela = Veiculo::TABELA;
            $campos = ['*', 'date_format(cadastro, "%d/%m/%Y %H:%i:%s") as cadastro', '&&case when isnull(modelo) then "" else modelo end as modelo', '&&case when isnull(cor) then "" else cor end as cor', '&&case when isnull(cidadePlaca) then "" else cidadePlaca end as cidadePlaca', '&&case when isnull(observacoes) then "" else observacoes end as observacoes'];
            $quantidade = 1;
            $pagina = null;

            $condicao = 'id = ?';
            $valorCondicao = [$_POST['id']];

            $orderBy = "";
            $debug = false;

            $registro = $bo->selecionarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
        } else {
            $registro = [];
        }

        echo json_encode($registro);        
    }

    public function listarGrafico() {
        $this->validaUsuario();

        $bo = new RegistroBO();

        $tabela = registro::TABELA;
        $campos = ['date_format(entrada, "%d/%m/%y") as entrada', 'count(id) as total'];
        $quantidade = is_numeric($_POST['quant']) ? $_POST['quant'] : null;
        $pagina = null;

        $condicao = 'status = ? or status = ? group by DATE_FORMAT(entrada, "%d-%m-%Y")';
        $valorCondicao = [1, 2];

        $orderBy = 'date(entrada) desc';
        $debug = false;

        $lista = $bo->listarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
        $array = [];
        $array2 = [];
        
        for($i = count($lista) - 1; $i >= 0; $i--){
            array_push($array2, $lista[$i]['total']);
            array_push($array, $lista[$i]['entrada']);
        }
        
        $x["label"] = $array;
        $x["total"] = $array2;
        
        echo json_encode($x);                
    }
    
    public function atualizarDadosVeiculo() {
        $this->validaUsuario();
        $this->nivelAcesso(4);

        if($_POST['campo'] != '' and $_POST['valor'] != '' and is_numeric($_POST['id'])){
            $bo = new RegistroBO();
            $tabela = Veiculo::TABELA;

            $dados = [
                $_POST['campo'] => $_POST['valor']
            ];

            $condicao = "id = ?";
            $valorCondicao = [$_POST['id']];
            $quantidade = 1;
            $validacao = [];
            
            $resposta = $bo->update($tabela, $dados, $condicao, $valorCondicao, $quantidade, $validacao);
            
            if($resposta){
                
                $info = [
                    'tipo' => 2,
                    'tabela' => Veiculo::TABELA,
                    'campos' => $dados,
                    'descricao' => 'O '.Sessao::getUsuario('tipo_usuario').' [nome], efetuou a edição de um veículo no sistema.'
                ];

                $this->inserirAuditoria($info);

                $retorno = [
                    "status" => 1,
                    "msg" => "Alteração salva!"
                ];            
            } else {
                $retorno = [
                    "status" => 0,
                    "msg" => "Falha ao concluir alteração!"
                ];                            
            }
        } else {
            $retorno = [
                "status" => 0,
                "msg" => "Acesso incorreto!"
            ];            
        }

        echo json_encode($retorno); 
   
    }
    
    public function listar($param) {
        $this->validaUsuario();
        $this->nivelAcesso(4);

        $bo = new RegistroBO();
        
        $tabela = Registro::TABELA . " r inner join " . Veiculo::TABELA . " v on r.veiculo_id = v.id";
        $campos = ["v.*","r.*", "date_format(entrada, '%d/%m/%Y %H:%i') as entrada", "date_format(saida, '%d/%m/%Y %H:%i') as saida"];
        
        $busca = $param[0];
        
        if($busca == "todos"){
            $condicao = "";
            $valorCondicao = [];
            $busca = "Todos os registros";
            $this->setViewParam("quant", 0);
        } else if($busca == "ultimo30"){
            $condicao = "DATE(entrada) >= DATE_ADD(NOW(), INTERVAL -30 DAY)";
            $valorCondicao = [];            
            $busca = "Registros dos ultimos 30 dias";
            $this->setViewParam("quant", 30);
        } else if($busca == "ultimo7"){
            $condicao = "DATE(entrada) >= DATE_ADD(NOW(), INTERVAL -7 DAY)";
            $valorCondicao = [];            
            $busca = "Registros dos ultimos 7 dias";
            $this->setViewParam("quant", 7);
        } else {
            $condicao = "DATE(entrada) = DATE(now())";
            $valorCondicao = [];
            $busca = "Registros de hoje";
            $this->setViewParam("quant", 3);
        }
        
        $lista = $bo->listarVetor($tabela, $campos, null, null, $condicao, $valorCondicao, "r.id desc");
        $this->setViewParam("busca", $busca);
        $this->setViewParam("lista", $lista);
        $this->render('registro/listar');
    }
}