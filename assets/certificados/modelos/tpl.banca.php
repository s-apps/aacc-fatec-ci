<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>AACC - Atividades Acadêmico-Científico-Culturais</title>
            <link rel="stylesheet" href="{{ base_url }}assets/css/pdf.css">
			<link rel="stylesheet" href="{{ base_url }}assets/css/bootstrap.min.css">
		</head>
		<body>
            <table class="table table-borderless">
                <tr>
                    <td><img src="{{ base_url }}assets/img/logo_header.png" class="imgheader"></td>
                    <td style="text-align:right;padding-right:35px;font-size:55px;font-weight:bold;padding-top:45px;">CERTIFICADO</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:26px;">
                        <p style="text-align:justify;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A Faculdade de Tecnologia de Garça certifica que {{ nome_aluno }} assistiu
                                        a Banca de Avaliação da Monografia "{{ titulo_monografia }}: {{ subtitulo_monografia }}", no dia {{ data_atividade }}, elaborada pelo aluno {{ nome_completo_orientando }} do Curso Superior de {{ do_curso_superior_de }}.</p>

                    </td>
                </tr>
            </table>
            <footer class="footer">
                <div style="height:110px;text-align:right;padding-top:65px;padding-right:60px;font-size:20px;background: url({{ base_url }}assets/img/assinatura/{{ assinatura }}) right top no-repeat;"><strong>{{ nome_diretor }}</strong><br/>Diretor(a) da Fatec Garça</div>
                <p><img src="{{ base_url }}assets/img/logo_footer.png" class="imgfooter"></p>
            </footer>
        </body>
    </html>