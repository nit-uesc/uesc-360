  <!--Essa classe define a quantidade de colunas que o card ocupará -->

	<div class="card-panel">

    <ul class="tabs" style="height: 60px;">
      <!-- Oculta o titulo da coluna pessoas da tabela quando não tem pessoas -->
			<?php if (count($pessoa) != 0 && (($check[0]) == 'true')): ?>
				 <?php $conPes = count ($pessoa) ?> <!-- Pega a quantide de pessoas -->
         <li class="tab col s4" style="text-align:left;margin-left:15px; line-height:20px;">
					<!-- <a href="#tPes">Pessoas <?php echo $conPes;?> </a><a href="#tPes">Pessoas</a>-->
					 <ul>
							 <li><p style="text-align:left; color:#ee6e73;  font-weight: bold;">PESSOAS</p></li>
							 <li><p style="text-align:left; margin-top: -15px;  font-size: 12px;"> <?php echo $conPes;?> Resultados </p></li>
					 </ul>
				 </li>
			<?php endif; ?>

      <!-- Oculta o titulo da coluna laboratorio da tabela quando não tem laboratorio -->
			<?php if (count($laboratorio) != 0  && (($check[1]) == 'true')): ?>
			   <?php $conLab = count ($laboratorio) ?> <!--Pega a aquintidade de laboratorios -->
         <li class="tab col s4" style="text-align:left;margin-left:15px; line-height:20px;">
					 <!--<a href="#tLab">Laboratórios <?php echo $conLab;?></a>-->
					 <ul>
							 <li><p style="text-align:left; color:#ee6e73;  font-weight: bold;">LABORATÓRIOS</p></li>
							 <li><p style="text-align:left; margin-top: -15px;  font-size: 12px;"><?php echo $conLab;?> Resultados </p></li>
					 </ul>
				 </li>
			<?php endif; ?>

			<!-- Oculta o titulo da coluna equipamento da tabela quando não tem equipamentos -->
			<?php if (count($equipamento) != 0  && (($check[2]) == 'true')): ?>
				 <?php $conEqi = count ($equipamento) ?><!-- pega a quantidade de equipamentos -->
         <li class="tab col s4" style="text-align:left;margin-left:15px; line-height:20px;">
					  <!--<a href="#tEqp">Equipamentos <?php echo $conEqi;?></a>-->
						<ul>
								<li><p style="text-align:left; color:#ee6e73;  font-weight: bold;">Equipamentos</p></li>
								<li><p style="text-align:left; margin-top: -15px;  font-size: 12px;"><?php echo $conEqi;?> Resultados </p></li>
						</ul>
				 </li>
			<?php endif; ?>
    </ul>

		<div id="tPes" class="row">
    	<div class="col s12">
	      <table class="striped" id="tbPequisa">
	      	<br>
	        <tbody>

						<?php
						for ($i = 0; $i <= $maior; $i++) {?>
							 <tr>


							<!--Se o numero de  pessoas na lista for menor que a variavel que guarda a quantidade maxima de linhas escrevo a linha de
							uma pessoa e o checkbox de pessoa esteja marcado-->
							<?php if($i < (count ($pessoa))  && (($check[0]) == 'true')):?>

										    <!-- deixa a coluna com um tamanho de acordo com a quantidade de colunas que tem elementos -->
												<?php if(((count ($laboratorio)) == 0) && ((count ($equipamento)) == 0)   || ((($check[1]) == 'false') && (($check[2]) == 'false'))):?>
														<td class=" col s12" style="padding:10px;">
											  <?php elseif(((count ($laboratorio)) != 0) && ((count ($equipamento)) != 0) && ((($check[1]) == 'true') && (($check[2]) == 'true'))): ?>

													  <td class=" col s4" style="padding:10px;">

												<?php elseif(((count ($laboratorio)) == 0) || ((count ($equipamento)) == 0) || ((($check[1]) == 'false') || (($check[2]) == 'false'))): ?>
												  	<td class=" col s6" style="padding:10px;">

												<?php endif ?>
																<?php $pes = $pessoa[$i]; ?>
												 			  <a href="<?php echo base_url('search/pessoa/'.$pes->id); ?>">
														 				<i class="material-icons left">person</i>
														 				<?php echo $pes->name;?>
																</a>
									  				</td>
								 <?php  endif ?>



								 <?php if($i <(count ($laboratorio)) && (($check[1]) == 'true')):?>
											<!-- deixa a coluna com um tamanho de acordo com a quantidade de colunas que tem elementos
										       ou com os check selecionados-->
											<?php if((((count ($pessoa)) == 0) && ((count ($equipamento)) == 0)) || ((($check[0]) == 'false') && (($check[2]) == 'false')) ):?>
														<td class="col s12"style="padding:10px;" >

											<?php elseif(((count ($pessoa)) == 0) || ((count ($equipamento)) == 0) || ((($check[0]) == 'false') || (($check[2]) == 'false'))): ?>
														<?php if( ((count ($pessoa)) != 0) && ($i+1) > (count ($pessoa)) && (($check[0]) == 'true')):  ?>
															 <td class="col s6"style="padding:10px;" >
														   <td class="col s6"style="padding:10px;" >

													 <?php else: ?>

														 <td class="col s6"style="padding:10px;" >

													 <?php endif ?>
											<?php elseif(((count ($pessoa)) != 0) && ((count ($equipamento)) != 0) || ((($check[0]) == 'true') || (($check[2]) == 'true'))): ?>

														<?php if($i >= (count ($pessoa))): ?>
																<td class="col s4 te"style="padding:10px;" >
																<td class="col s4 te"style="padding:10px;" >

														<?php else: ?>
																<td class="col s4 te"style="padding:10px;" >

														<?php endif ?>
											<?php endif ?>
																<?php $lab = $laboratorio[$i]; ?>
												 				<a href="<?php echo base_url('search/laboratorio/'.$lab->id); ?>">
												 				<i class="material-icons left">group_work</i>

																<!-- caso o laboratorio tenha sigla adiciona-->  
																<?php if($lab->info3 != ''): ?>
																		<?php echo $lab->name;?> - <?php echo $lab->info3;?>
															  <?php else: ?>
																		<?php echo $lab->name;?>
																<?php endif?>
															  </a>
							 		          </td>
									<?php endif ?>


									<?php if($i <(count ($equipamento)) && (($check[2]) == 'true')):?>

												<!-- deixa a coluna com um tamanho de acordo com a quantidade de colunas que tem elementos -->
												<?php if(((count ($pessoa)) == 0) && ((count ($laboratorio)) == 0)):?>
															<td class="col s12"style="padding:10px;" >

												<?php elseif(((count ($pessoa)) == 0) || ((count ($laboratorio)) == 0) || ((($check[0]) == 'false') || (($check[1]) == 'false'))): ?>
													    <?php if( ((count ($pessoa)) != 0) && ($i+1) > (count ($pessoa)) && (($check[0]) == 'true')): ?>
																	<td class="col s6"style="padding:10px;" >
																  <td class="col s6"style="padding:10px;" >
															<?php elseif( ((count ($laboratorio)) != 0) && ($i+1) > (count ($laboratorio)) && (($check[1]) == 'true')): ?>
																  <td class="col s6"style="padding:10px;" >
																  <td class="col s6"style="padding:10px;" >
														 <?php else:  ?>
																	<td class="col s6"style="padding:10px;" >


														 <?php endif ?>
												<?php elseif(((count ($pessoa)) != 0) && ((count ($laboratorio)) != 0)): ?>

															  <!--Caso a quantidade de equipamentos seja maior que a de pessoas e laboratorio adciono colunas vazias -->
																<?php if($i >= (count ($pessoa)) && $i >= (count ($laboratorio)) ): ?>
																		<td class="col s4"style="padding:10px;" >
																		<td class="col s4"style="padding:10px;" >
																		<td class="col s4"style="padding:10px;" >
																<?php elseif ($i <= (count ($pessoa)) && $i >= (count ($laboratorio))):?>
																		<td class="col s4"style="padding:10px;" >
																		<td class="col s4"style="padding:10px;" >
																		<?php else: ?>
																		<td class="col s4"style="padding:10px;" >
																<?php endif ?>

												<?php endif ?>

																	<?php $eq = $equipamento[$i]; ?>
													 			  <a href="<?php echo base_url('search/equipamento/'.$eq->id); ?>">
													 				<i class="material-icons left">build</i>
																  <?php echo $eq->name;?>
													 			  </a>
															</td>
								<?php endif ?>
							 	</tr>
				    <?php	} ?>
	        </tbody>
	      </table>
    	</div>
  	</div>

	</div>
