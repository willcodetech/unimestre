# unimestre
Case de exemplo com desenvolvimento PHP

Exame para avaliação de desenvolvimento em programação
Um cliente está solicitando um cadastro de currículos para seu site, esta é uma oportunidade de mercado para um novo serviço que precisa ser desenvolvido. Os requisitos solicitados pelo cliente estão relacionados abaixo:
- Desenvolver um sistema de cadastro de currículos com a linguagem de programação (PHP, Node, Python, C#, etc, pode ser utilizado qualquer linguagem de programação da preferência do candidato), para internet e banco de dados (MySQL ou SQLite).
- Quando entrar no sistema o usuário precisa ser direcionado para a página de cadastro de seu currículo. As informações a serem preenchidas são: Nome, E-mail, Login, Senha, CPF, Data de Nascimento, Sexo, Estado Civil, Escolaridade, Cursos/ Especializações, Experiência Profissional e pretenção salarial. Você precisa salvar na base de dados a data e hora que o currículo foi registrado no sistema.
- O usuário pode querer alterar seu próprio currículo outro dia. Para isso, desenvolva também uma página de login (que faça a validação do Login e da Senha digitada no cadastro). 
- Após estar logado, ou ter completado o cadastro, o usuário poderá registrar (ou alterar) seu currículo no sistema.
- O cliente também precisa de um acesso a uma página que liste todos os currículos cadastrados. Esta página deve exibir na lista a "pretensão salarial”. Ao final da lista, em formato de relatório exibir a soma total de "pretensão salarial” de todos os candidatos e a média de pretensão salarial. O sistema deve pintar na lista os salários em verde que estão abaixo da média salarial e em Azul os que estão acima da média salarial.
Abaixo as especificações a serem utilizadas para programação:
Após o envio do formulário de currículo mostrar uma mensagem amigável de inserção ou alteração.


Se o usuário já tiver um currículo registrado, permitir a alteração do mesmo (mostrando os campos já cadastrados pelo usuário após a realização do login)


Os campos de formato Data devem ser tratados na inserção/alteração (usar o comando substr, split, explode, etc). Lembrando que o usuário deve digitar “dia/mês/ano” e na base deve ficar salvo como “ano-mês-dia”.

Bônus opcionais
Verificar se o login já existe na base de dados antes da inserção e alteração.


Testar o CPF no frontend através de javascript.


Verificar se os campos Nome, Email, Login, CPF foram digitados antes de enviar o form por Javascript.

Grave um vídeo com as suas explicações, e encaminhe o vídeo gravado, com o repositório no GIT para avaliação do código fonte.

Boa sorte!
