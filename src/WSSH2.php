<?php
/**
 * Classe para conexão via SSH utilizando PHP
 * Depende da biblioteca ssh2 'php_ssh2'
 */
namespace WerlonGuilherme\PHPSSH2;

/**
 * @author Werlon Guilherme
 * @package WerlonGuilherme\PHPSSH2
 * @uses $obj = new \WerlonGuilherme\PHPSSH2\WSSH2
 * $obj->conectar('caminho',22);
 * $obj->autenticar('usuario','senha');
 * $obj->executar('faz isso',$erros);
 * $obj->desconectar();
 */
class WSSH2{
    /**
     * @var resource
     */
    private $conexao;

    /**
     * @param string $caminho
     * @param int $porta
     * @return bool
     */
    public function conectar(string $caminho, int $porta) : bool 
    {
        $this->conexao = ssh2_connect($caminho, $porta);
        return $this->conexao ? true : false;
    }

    /**
     * @param string $usuario
     * @param string $senha
     * @return bool
     */
    public function autenticar(string $usuario, string $senha) : bool
    {
        return $this->conexao ? ssh2_auth_password($this->conexao,$usuario,$senha) : false;
    }

    /**
     * @return bool
     */
    public function disconectar() : bool 
    {
        if($this->conexao) ssh2_disconnect($this->conexao);
        $this->conexao = null;
        return true;
    }

    /**
     * @param string $comando
     * @param string $erros
     * @return string|null por esperar dois retornos não declaramos o retorno
     */
    public function executar(string $comando,string &$erros = null)
    {
        if(!$this->conexao) return null;
        if(!$fluxo = ssh2_exec($this->conexao,$comando)){
            return null;
        }
        stream_set_blocking($fluxo,true);
        $resposta = $this->getRetorno($fluxo, SSH2_STREAM_STDIO);
        $erros = $this->getRetorno($fluxo, SSH2_STREAM_STDERR);
        stream_set_blocking($fluxo,false);
        return $resposta;
    }

    /**
     * @param resource $fluxo
     * @param int $referencia
     * @return string
     */
    private function getRetorno($fluxo,$referencia) : string
    {
        $retorno = ssh2_fetch_stream($fluxo,$referencia);
        return stream_get_contents($retorno);
    }
}