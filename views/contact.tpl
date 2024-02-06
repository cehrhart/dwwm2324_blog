{extends file="views/layout.tpl"}

{block name="contenu"}
			<div class="row g-5">
				<div class="col-md-4">
					<div class="position-sticky" style="top: 2rem;">
						<div id="map">
							<iframe width="100%" height="500px" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d85245.75141192738!2d7.322364206894916!3d48.11159122156081!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x479165dff670c1cf%3A0xe35d7e3e616ce966!2s68000+Colmar!5e0!3m2!1sfr!2sfr!4v1539164589375" allowfullscreen></iframe>			
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<h3 class="pb-4 mb-4 fst-italic border-bottom">
						Contactez nous
					</h3>

					<form name="contactForm" action="#" method="post" novalidate onSubmit="verifForm();return false;">
						<div class="row g-3">
							<p>Les informations obligatoires sont suivies d'un *</p>
							<div id="message"></div>
							<div class="my-3">
								<div class="form-check">
								  <input id="civ_mlle" name="civ" type="radio" class="form-check-input">
								  <label class="form-check-label" for="civ_mlle">Mlle</label>
								</div>
								<div class="form-check">
								  <input id="civ_mme" name="civ" type="radio" class="form-check-input">
								  <label class="form-check-label" for="civ_mme">Mme</label>
								</div>
								<div class="form-check">
								  <input id="civ_m" name="civ" type="radio" class="form-check-input">
								  <label class="form-check-label" for="civ_m">M</label>
								</div>
							</div>
							<div class="col-sm-6">
							  <label for="name" class="form-label">Nom*</label>
							  <input type="text" class="form-control" id="name" >
							</div>
							<div class="col-sm-6">
							  <label for="firstname" class="form-label">Prénom*</label>
							  <input type="text" class="form-control" id="firstname" >
							</div>
							<div class="col-12">
							  <label for="email" class="form-label">Adresse mail*</label>
							  <input type="email" class="form-control" id="email" placeholder="you@example.com">
							</div>
							<div class="col-12 form-check">
								<input type="checkbox" class="form-check-input" id="sendmail">
								<label class="form-check-label" for="sendmail">copie du message</label>
							</div>
							<div class="col-sm-6">
								<label for="tel" class="form-label">Numéro de téléphone</label>
								<input type="text" class="form-control" name="tel" id="tel" >
							</div>
							<div class="col-sm-12">
								<label for="subject" class="form-label">Sujet du message*</label>
								<input type="text" required class="form-control" name="subject" id="subject" >
							</div>
							<div class="col-sm-12">
								<label for="content" class="form-label">Contenu du message*</label>
								<textarea required class="form-control" name="content" id="content"></textarea></p>
							</div>
							<div class="col-12 form-check">
								<input required type="checkbox" class="form-check-input" name="rgpd" id="rgpd" />
								<label for="rgpd">Accepter les conditions RGPD</label>
							</div>
							<p>
								<input class="btn btn-primary" type="submit" value="Envoyer le message" />
							</p>
					</form>
				</div>

			</div>

{/block}