<?php

namespace App\Controllers;

use App\Lib\Sessao;
use App\Models\BO\TipoUsuarioBO;
use App\Models\Entidades\TipoUsuario;
use App\Models\BO\PermissaoBO;
use App\Models\Entidades\Permissao;
use App\Models\Entidades\TipoUsuarioPermissao;
use App\Models\BO\TipoUsuarioPermissaoBO;
use App\Models\BO\UsuarioBO;

class PerfisController extends Controller{   
    public function index(){
        $this->validaUsuario();
        $this->nivelAcesso(1);
        $this->redirect('perfis/listar');
    }

    public function listar($parametro) {
        $this->validaUsuario();
        $this->nivelAcesso(1);
        
        $bo = new TipoUsuarioBO();
        
        if(!is_numeric($parametro[0])){
            $this->redirect('perfis/listar/1/'. $parametro[0]);
        }
        $p = (isset($parametro[0]) or is_numeric($parametro[0])) ? $parametro[0] : 1;
        $busca = (isset($parametro[1])) ? $parametro[1] : null;
        
        $quantidade = 5;
        $pagina = $p * $quantidade - $quantidade;
        
        $condicao = "";
        $valoresCondicao = [];

        if($busca){
            $condicao .= "descricao like '%?%'";
            array_push($valoresCondicao, "$busca");
        }
        
        $orderBy = "descricao";
        
        $resultado = $bo->listar(TipoUsuario::TABELA, ["id", "descricao"], $quantidade, $pagina, $condicao, $valoresCondicao, $orderBy);
        $this->setViewParam('perfis', $resultado);
        $quanPerfils = $bo->selecionar(TipoUsuario::TABELA, ["count(id) as id"], null, null, $condicao, $valoresCondicao, $orderBy);

        $quanPaginas = ceil($quanPerfils->getId() / $quantidade);

        if($p > $quanPaginas and $p != 1){
            Sessao::gravaMensagem("Página não encontrada!", 2);
            $this->redirect('perfis/listar');
        }
        
        if($p < 5){
            $i = 0;
            $fim = $quanPaginas < 5 ? $quanPaginas : 5;   
        }else{
            if($p < $quanPaginas - 2){
                $i = $p - 3;
                $fim = $p + 2;
            } else {
                $i = $quanPaginas - 5;
                $fim = $quanPaginas;                                        
            }
        }

        $paginacao = array(
            'quanPerfils' => $quanPerfils->getId(),
            'quanPaginas' => $quanPaginas,
            'inicio' => $i,
            'fim' => $fim,
            'pagina' =>$p,
            'anterior' => $p - 1,
            'proxima' => $p + 1,
            'busca' => $busca
        );
        $this->setViewParam('paginacao', $paginacao);

        if($quanPerfils->getId() < 1){
            Sessao::gravaMensagem('Nenhum registro encontrado!', 2);
        }

        $this->render('perfis/listar', "teste");
    }
    
    public function visualizar($param) {
        $this->validaUsuario();
        $this->nivelAcesso(1);
       
        $id = $param[0];

        if(is_numeric($id)){
            $bo = new TipoUsuarioBO();

            $tabela = TipoUsuario::TABELA;
            $campos = ['*'];
            $condicao = "id = ?";
            $quantidade = 1;
            $pagina = null;
            $valorCondicao = [$id];
            $orderBy = null;
            $debug = false;

            $resultado = $bo->selecionarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);

            if($resultado == FALSE){
                $mensagem = "Perfil não encontrado.";
                Sessao::gravaMensagem($mensagem, 2);

                $this->redirect('perfis/listar');
            }else{
                $tabela = TipoUsuarioPermissao::TABELA . ' tup inner join ' . Permissao::TABELA . ' p on tup.permissao_id = p.id';
                $campos = ['p.*'];
                $condicao = "tup.tipo_usuario_id = ?";
                $quantidade = null;
                $valorCondicao = [$id];
                $resultado['permissoes'] = $bo->listarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
                
                $this->setViewParam('perfil', $resultado);

                $bo = new UsuarioBO();

                $quantidade = null;
                $pagina = null;
                $condicao = "tipo_usuario_id = ?";
                $valoresCondicao = [$resultado['id']];
                $orderBy = "nome asc";
                
                $resultado = $bo->listar(\App\Models\Entidades\Usuario::TABELA, ["*"], $quantidade, $pagina, $condicao, $valoresCondicao, $orderBy);

                $this->setViewParam('usuarios', $resultado);
                
                $this->render('perfis/visualizar', "Perfil: ".$resultado['descricao']);
            }
        } else {
            $mensagem = "Acesso incorreto!";
            Sessao::gravaMensagem($mensagem, 2);

            $this->redirect('perfis/listar');
        }           
    }
    
    public function cadastro(){
        $this->validaUsuario();
        $this->nivelAcesso(1);
        
        $permissaoBO = new PermissaoBO();
        
        $permissoes = $permissaoBO->listarVetor(Permissao::TABELA, ['*'], null, null, null, null, "nivel ASC");

        $this->setViewParam("permissoes", $permissoes);

        $this->render('perfis/cadastro', "teste");        
    }
    
    public function editar($param) {
        $this->validaUsuario();
        $this->nivelAcesso(1);

        $id = $param[0];

        if(is_numeric($id)){
            $bo = new TipoUsuarioBO();

            $tabela = TipoUsuario::TABELA;
            $campos = ['*'];
            $condicao = "id = ?";
            $quantidade = 1;
            $pagina = null;
            $valorCondicao = [$id];
            $orderBy = null;
            $debug = false;

            $resultado = $bo->selecionarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);

            if($resultado == FALSE){
                $mensagem = "Perfil não encontrado.";
                Sessao::gravaMensagem($mensagem, 2);

                $this->redirect('perfis/listar');
            }else{
                $tabela = TipoUsuarioPermissao::TABELA . ' tup inner join ' . Permissao::TABELA . ' p on tup.permissao_id = p.id';
                $campos = ['p.id'];
                $condicao = "tup.tipo_usuario_id = ?";
                $quantidade = null;
                $valorCondicao = [$id];
                $resultado['permissoes'] = array();
                $array = $bo->listarVetor($tabela, $campos, $quantidade, $pagina, $condicao, $valorCondicao, $orderBy, $debug);
                foreach ($array as $key => $valor){
                    array_push($resultado['permissoes'], $valor['id']);
                }
                
                $this->setViewParam('perfil', $resultado);

                $permissoes = $bo->listarVetor(Permissao::TABELA, ['*'], null, null, null, null, "nivel ASC");

                $this->setViewParam("permissoes", $permissoes);
                
                $this->render('perfis/editar', "Perfil: ".$resultado['descricao']);
            }
        } else {
            $mensagem = "Acesso incorreto!";
            Sessao::gravaMensagem($mensagem, 2);

            $this->redirect('perfis/');
        }           
    }
    
    public function salvar() {
        $this->validaUsuario();
        $this->nivelAcesso(1);
        
        if(count($_POST)){
            $bo = new TipoUsuarioBO();
            $perfilPermissoesBO = new TipoUsuarioPermissaoBO();
            $vetor = $_POST;
            
            if(is_numeric($vetor['id'])){
                $dados = array();
                $campus = ['descricao'];

                foreach( $vetor as $indice => $valor ) {
                    if(in_array($indice, $campus)){
                        if($vetor[$indice] == ''){
                            $dados[$indice] = "null";
                        } else {
                            $dados[$indice] = $vetor[$indice];                        
                        }
                    }
                }

                $validacao = ['descricao'];
                $condicao = "id = ?";
                $valorCondicao = [$vetor['id']];

                if(count($vetor['permissoes_id']) == 0){
                    $mensagem = "Perfil sem alteração.<br>Preencha alguma permissão";
                    Sessao::gravaMensagem($mensagem, 2);

                    $this->redirect('perfis/visualizar/'.$vetor['id']);
                }else{               
                    $bo->update(TipoUsuario::TABELA, $dados, $condicao, $valorCondicao, 1, $validacao);
                    $perfilPermissoesBO->excluir(TipoUsuarioPermissao::TABELA, "tipo_usuario_id = ? and permissao_id > 0", [$vetor['id']], null, false);

                    $dadosPermissoes = $vetor['permissoes_id'];
                    $validacaoPermissoes = ['tipo_usuario_id', 'permissao_id'];
 
                    foreach ($dadosPermissoes as $item){
                        $dados = [
                            'tipo_usuario_id' => $vetor['id'],
                            'permissao_id' => $item
                        ];

                        $perfilPermissoesBO->inserir(TipoUsuarioPermissao::TABELA, $dados, $validacaoPermissoes);
                    }

                    $mensagem = "Perfil alterado";
                    Sessao::gravaMensagem($mensagem,1);
                    $this->atualizar_dados_usuario_sessao();

                    $this->redirect('perfis/visualizar/'.$vetor['id']);
                }                
            } else {

                $dados = array();
                $campus = ['descricao'];

                foreach( $vetor as $indice => $valor ) {
                    if(in_array($indice, $campus)){
                        if($vetor[$indice] == ''){
                            $dados[$indice] = "null";
                        } else {
                            $dados[$indice] = $vetor[$indice];                        
                        }
                    }
                }

                $validacao = ['descricao'];
                
                if(count($vetor['permissoes_id']) > 0){
                    $id = $bo->inserir(TipoUsuario::TABELA, $dados, $validacao);
                } else {
                    $id = false;
                } 
                
                if($id == FALSE){
                    $mensagem = "Falha ao cadastrar perfil.<br>Preencha alguma permissão";
                    Sessao::gravaMensagem($mensagem, 3);

                    $this->redirect('perfis/cadastro');
                }else{                
                    $dadosPermissoes = $vetor['permissoes_id'];
                    $validacaoPermissoes = ['tipo_usuario_id', 'permissao_id'];
 
                    foreach ($dadosPermissoes as $item){
                        $dados = [
                            'tipo_usuario_id' => $id,
                            'permissao_id' => $item
                        ];

                        $perfilPermissoesBO->inserir(TipoUsuarioPermissao::TABELA, $dados, $validacaoPermissoes);                        
                    }

                    $auditoriaBO = new \App\Models\BO\AuditoriaBO();
                    $dados = [
                        'tipo' => "Cadastro de perfil",
                        'usuario' => Sessao::getUsuario('id') . ' - ' . Sessao::getUsuario('usuario'),
                        'detalhes' => Sessao::getUsuario('tipo_usuario_nome') . ': ' . Sessao::getUsuario('usuario') . ', efetuou o cadastro do perfil: ' . $id . ' - ' . $vetor['descricao'],
                        'data' => date('Y-m-d H:i:s')
                    ];
                    $auditoriaBO->inserir(\App\Models\Entidades\Auditoria::TABELA, $dados, ['tipo', 'usuario', 'detalhes']);

                    $mensagem = "Perfil cadastrado";
                    Sessao::gravaMensagem($mensagem);

                    $this->redirect('perfis/listar/'.$vetor['descricao']);
                }
            }
        } else {
            $mensagem = "Acesso incorreto!";
            Sessao::gravaMensagem($mensagem, 2);

            $this->redirect('perfis/listar');
        }           
        
    }

    public function apagar($param) {
        $this->validaUsuario();
        $this->nivelAcesso(1);
        
        $id = $param[0];

        if(is_numeric($id)){
            $bo = new TipoUsuarioBO();
            $UsuarioBO = new UsuarioBO();
            
            $a = $UsuarioBO->listarVetor(\App\Models\Entidades\Usuario::TABELA, ['*'], null, null, "tipo_usuario_id = ?", [$id], '');

            if(count($a) < 1){
                $perfil = $bo->selecionarVetor(TipoUsuario::TABELA, ['id', 'descricao'], 1, null, 'id = ?', [$id]);

                $tabela = TipoUsuarioPermissao::TABELA;
                $condicao = "tipo_usuario_id = ? and permissao_id > 0";
                $valorCondicao = [$id];
                $quantidade = null;

                $bo->excluir($tabela, $condicao, $valorCondicao, $quantidade);

                $tabela = TipoUsuario::TABELA;
                $condicao = "id = ?";
                $valorCondicao = [$id];
                $quantidade = 1;

                $resultado = $bo->excluir($tabela, $condicao, $valorCondicao, $quantidade);
                if($resultado){
                    $mensagem = "Perfil excluido!";
                    Sessao::gravaMensagem($mensagem, 1);

                    $this->redirect('perfis/');

                } else {
                    $mensagem = "Perfil não excluido!";
                    Sessao::gravaMensagem($mensagem, 3);

                    $this->redirect('perfis/');                
                }
            } else {
                $mensagem = "Perfil não excluido!<br>Verifique se não existem usuários nesse perfil.";
                Sessao::gravaMensagem($mensagem, 3);

                $this->redirect('perfis/visualizar/'.$id);                
            }
        } else {
            $mensagem = "Acesso incorreto!";
            Sessao::gravaMensagem($mensagem, 2);

            $this->redirect('perfis/');
        }           
    }
    
}