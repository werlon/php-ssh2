#PHP SSH2

Conecta via SSH pelo PHP utilizando a lib PHP_SSH2

#COMO INSTALAR
```shell
composer install werlon/php-ssh2
```

#COMO USAR

Segue codigo exemplo utilizando a classe
```php
<?php
require __DIR__.'/vendor/autoload.php';
// Importa a classe a ser utilizada
use \WerlonGuilherme\PHPSSH2\WSSH2;

// Prepara as variáveis
$caminho = '127.0.0.1';//IP ou caminho do seu HOST
$porta = 22;//PORTA da conexão
$usuario = 'usuario';//USUÁRIO para autenticar
$senha = 'senha';//SENHA para autenticar
$comando = 'ls -la';//COMANDO a ser executado no servido

// Instancia a classe
$objetoSSH2 = new WSSH2;

// Inicia conexão
if(!$objetoSSH2->conectar($caminho,$porta)){
    die('Não foi possível Conectar');
}

// Manda autenticar a conexão
if(!$objetoSSH2->autenticar($usuario,$senha)){
    die('Não foi possível Autenticar');
}

echo "Conectado: \n";

// Envia o comando e pega a saida e erros.
// A variável de erro é criada neste momento por isso não é declarada antes
$saida =  $objetoSSH2->executar($comando,$erros);

// Mostra erro se tiver
echo "ERRO:\n";
echo $erros ? $erros : 'SEM ERROS'; 
echo "\n";

// Mostra a saida do comando
echo "SAÍDA:\n".$saida."\n";

// Manda fechar a conexao
$objetoSSH2->disconectar();
echo "Desconectado \n";

```

## Requisitos

PHP 7.3 ou superior
Baixar ou instalar a biblioteca php_ssh2 em sua pasta de extensões do PHP
[SSH2 PHP](https://pecl.php.net/package/ssh2) 

DLL para windows
[SSH2 PHP DLL](https://pecl.php.net/package/ssh2/1.3.1/windows)