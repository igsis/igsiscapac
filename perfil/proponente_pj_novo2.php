<section id="contact" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<h3>INFORMAÇÕES INICIAIS</h3>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?inicio.php" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Razão Social *:</strong><br/>
						<input type="text" class="form-control" name="razaoSocial" placeholder="Razão Social" >
					</div>
				</div>

				<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CNPJ *:</strong><br/>
							<input type="text" readonly class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" value="<?php echo $busca; ?>">
						</div>
						<div class="col-md-6"><strong>CCM:</strong><br/>
							<input type="text" class="form-control" id="ccm" name="ccm" placeholder="CCM" >
						</div>
					</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Celular *:</strong><br/>
						<input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" >
					</div>
					<div class="col-md-6"><strong>Telefone #2:</strong><br/>
						<input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" >
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #3:</strong><br/>
						<input type="text" class="form-control" name="telefone3" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" >
					</div>
					<div class="col-md-6"><strong>E-mail *:</strong><br/>
						<input type="text" class="form-control" name="email" placeholder="E-mail" >
					</div>
				</div>

				<!-- Botão para Gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
				</form>

				<!-- Links emissão de documentos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="table-responsive list_info"><h6>Gerar Arquivo(s)</h6>
						<p>Para gerar alguns dos arquivos online, utilize os links abaixo:</p>
							<div align="left">
								<a href="http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/cnpjreva_solicitacao.asp" target="_blank">Cartão CNPJ</a></i><br/><br />
								<a href="https://ccm.prefeitura.sp.gov.br/login/contribuinte?tipo=F" target="_blank">FDC CCM - Ficha de Dados Cadastrais de Contribuintes Mobiliários</a></i><br/><br />
								<a href='<?php echo $link1 ?>' target="_blank">Declaração CCM (Empresa Fora de São Paulo)</a></i><br/><br />
							</div>
						</div>
					</div>
				</div>

			<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
							<?php listaArquivoCamposMultiplos($idPessoaJuridica,$tipoPessoa,"","documentos_pj",2); ?>
						</div>
					</div>
				</div>

				<!-- Upload de arquivo 1 -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<div class = "center">
							<form method="POST" action="?perfil=documentos_pj" enctype="multipart/form-data">
								<table>
									<tr>
										<td width="50%"><td>
									</tr>
									<?php
										$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id = '9'";
										$query_arquivos = mysqli_query($con,$sql_arquivos);
										while($arq = mysqli_fetch_array($query_arquivos))
										{
									?>
									<tr>
										<td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
									</tr>
									<?php
										}
									?>
								</table><br>
							</div>
						</div>
					</div>

				<!-- Upload de arquivo 2 -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<div class = "center">
								<table>
									<tr>
										<td width="50%"><td>
									</tr>
									<?php 
										$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoPessoa = '$tipoPessoa' AND id = '21'";
										$query_arquivos = mysqli_query($con,$sql_arquivos);
										while($arq = mysqli_fetch_array($query_arquivos))
										{
									?>
											<tr>
												<td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
											</tr>
									<?php
										}
									?>
								</table><br>
								<input type="hidden" name="idPessoa" value="<?php echo $idPessoaJuridica ?>"  />
								<input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"  />
								<input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>
							</form>
							</div>
						</div>
					</div>
					<!-- Fim Upload de arquivo -->

			<div class="form-group">
				<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
			</div>

				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=inicio_pj" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
						</form>
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=endereco_pj" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
						</form>
				</div>

				<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>
				<!-- Botão para Prosseguir -->
				<div class="form-group">
					<form class="form-horizontal" role="form" action="?perfil=documentos_pj" method="post">
						<div class="col-md-offset-8 col-md-2">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaJuridica ?>">
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</section>