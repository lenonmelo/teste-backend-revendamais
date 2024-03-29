# Projeto do Lenon Platenetti de Melo

# Objetivo
O objetivo é disponibilizar uma estrutura de APIS para cadastro de informações de endereços com sus CEPs.<br>
Também rellziar busca por CEPs cadastrados no sistema e de serviços externos.<br>
E por fim realizar uma busca fuxxy search, aonde irá encontrar resultado aprocimados nos campos textuais existentes(Logradouros, Bairros, Cidades, Estadose UFs).

# Desenvolvimento
Para o desenvolvimento da aplicação foram utilizadas as seguintes tecnologias web.
* PHP versão 8.2.12;
* Framework Laravel versão 10.10;
* Biblioteca guzzlehttp versão 7.8;
* Autenticação com a bibliteca Sanctum versão 3.3;
* Composer versão 2.6.6;
* Banco Mysql versão 15.1.

# Decisões Técnicas
Durante o desenvolvimento, tomei as seguintes decisões técnicas:

* Criei um método para validar parâmetros em cada controller, evitando repetição em cada ação.
* Implementei a biblioteca RetornoMensagem para formatar mensagens de retorno.
* Desenvolvi a biblioteca ValidarId para validar dinamicamente a existência de IDs.

* Utilizei a biblioteca ViaCep para executar o endpoint de um serviço externo e retornar os dados.
Criei alguns arquivos de serviços para validar bairros, CEPs, cidades e estados (UFs), evitando sobrecarregar os models com métodos adicionais.

* Estabeleci regras de validação de CEP para o validador do framework.
* Implementei regras de validação de chaves estrangeiras dinâmicas para o validador do framework.
Utilizei a biblioteca externa Guzzle para executar a API de busca de endereço por CEP.
* Escolhi o serviço externo viacep.com.br pela sua facilidade de uso e pela abrangência da sua base de dados.

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

* As tabelas serão criadas conforme o MER abaixo.

  ![MER](https://github.com/lenonmelo/teste-backend-revendamais/blob/main/DBMER.png?raw=true)


* Além disso, execute o seguinte comando para executar a seed, que incluirá os dados do usuário admin na tabela de usuários e alguns edereços nas tabelas ceps, bairros, cidades e estados(UF).

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

[Postman Collection](https://github.com/lenonmelo/teste-backend-revendamais/blob/main/Projeto%20Revenda%20Mais.postman_collection.json)

# Instruções dos endpoints

* Todos eles devem ter o cabeçalho com a configuração a seguir.

      Accept:application/json
      Authorization:Bearer 8|vhG2Iois6...

* Para acessar os endpoints, a autenticação (Login) deverá ser feita.
* O tokem irá exporar em 1 hora.
* Após obter o token, ele deverá ser passado no cabeçalho como um token válido, conforme mostrado acima.
* Os detalhes dos endpoints estão disponíveis na coleção do Postman no arquivo de apoio.
* Para acessar, faça o download e importe no Postman.