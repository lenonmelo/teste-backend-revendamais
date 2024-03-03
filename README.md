# Projeto do Lenon Platenetti de Melo

# Objetivo
O objetivo é disponibilizar uma estrutura de APIS para cadastro de informações de endereços com sus CEPs.<br>
Também rellziar busca por CEPs cadastrados no sistema e de serviços externos.<br>
E por fim realizar uma busca fuxxy search, aonde irá encontrar resultado aprocimados nos campos textuais existentes(Logradouros, Bairros, Cidades, Estadose UFs).

# Desenvolvimento
Para o desenvolvimento da aplicação foram utilizadas as seguintes tecnologias web.
* PHP versão 8.2.12;
* Framework Laravel versão 10.10;
* Biblioteca guzzlehttp: Versão 7.8;
* Composer versão 2.6.6;
* Banco Mysql versão 15.1.

# Decições técnicas
Durante o desenvolvimento foram tomadas as seguintes decições técnicas.
* Criado o método para velidação de parâmetros em cada controller para não ter a necessidade de repetilo em cada action.
* Criada a library RetornoMensagem para tratar mensagens de retornos.
* Criada a library ValidarId para validar a existencia dos Ids dinamicamente.
* Criada a library ViaCep para realizar a execução do enpoint do srviço externo e retornar os dados.
* Criado um alguns arqhivos services para realizar ações referente a validação de bairros, ceps, cidades, estados(UF) com o objetivo de não poluir os models com métodos alem do padrão.
* Criado regra de validações de CEP para executar no validator do framework.
* Criado regra de validações de chaves estrangeiras dinãmicas para executar no validator do framework.
*utilização da biblioteca externa Guzzle para executar a api de busca de endereço por CEP.
* Foi utilizado o serviço externo viacep.com.br, por ser mais intuitivo de usar e ter uma base de dados mais completa.

# Rodar a aplicação
Para executar a aplicação, é necessário que o ambiente/máquina tenha as seguintes aplicações instaladas e configuradas:
* PHP 8.2.x, instalado e configurado nas variáveis de ambiente do sistema;
<br><b>OBS:</b> Você pode instalá-lo por meio de aplicações com ambientes prontos, como Xampp ou Wampp.
* Composer: Será utilizado para a instalação dos pacotes necessários.
* Artisan: Será utilizado para iniciar o servidor de teste.
<br><b>OBS:</b> O artisan já é instalado automaticamente ao criar um projeto Laravel.
* MySQL 15.X ou Maria DB.

Após concluir as instalações necessárias, siga estas etapas:
* Clonar o projeto na pasta que pretende executar a aplicação;
* Acesse a pasta principal da aplicação através do terminal.
* Execute o seguinte comando para instalar os pacotes necessários;

      composer install

* Faça uma cópia do arquivo ".env.example" encontrado na estrutura principal da aplicação e altere o nome para ".env".
* Nas configurações do banco de dados, inclua as informações referentes ao banco que será utilizado, conforme indicado abaixo:

      DB_CONNECTION=mysql <br>
      DB_HOST=127.0.0.1<br>
      DB_PORT=3306<br>
      DB_DATABASE=xxxxxxxx
      DB_USERNAME=xxxx
      DB_PASSWORD=xxxx

* Acesse o terminal e execute o seguinte comando na pasta principal do projeto:

      php artisan migrate

* Neste momento, o Artisan irá perguntar se deseja criar a base de dados; certifique-se de aceitar essa opção.
* Agora, o banco de dados será criado automaticamente, e as migrações serão executadas automaticamente.

* Além disso, execute o seguinte comando para executar a seed, que incluirá os dados do usuário admin na tabela de usuários.

      php artisan db:seed


* Agora, mais uma vez, através do terminal, na pasta principal da aplicação, execute o seguinte comando para iniciar o servidor de teste:

      php artisan serve 

* Acesse o endereço local do servidor no seu navegador, conforme exibido no terminal.
      
      http://127.0.0.1:8000

# Acesso

* O usuário e senha padrão de teste são as seguintes:

      Usuário: admin@teste.com.br
      Senha: admin

# Observação

* Quando você rodar o sistema pela primeira vez no servidor, pode ser que ele solicite a geração de uma chave de acesso. Nesse momento, basta clicar no botão exibido na tela para gerar a chave e, em seguida, acesse novamente o endereço.

# Arquivo de apoio

*Coleção do Postman com os endpoints utilizados na aplicação.

[Postman Collection]()

# Instruções dos endpoints

* Todos eles devem ter o cabeçalho com a configuração a seguir.

      Accept:application/json
      Authorization:Bearer 8|vhG2Iois6...

* Para acessar os endepoits a autenticação(Login) deverá ser feita.
* Após ter o token na mão, devera ser passado no cabeçalho o token válido, conforme mostrado acima.
* Detalhes dos endpoint estão na coleção do Postman no arquivo de apoio.
* Para acessar, faça o dowload e importe no Postam.