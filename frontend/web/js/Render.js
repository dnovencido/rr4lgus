var Render = function(){
	this.__construct = function(){
		console.log("Render initialized");
	};


	this.modal = function(options) {

		//Build file content modal
		var modal = `<div class="modal micromodal-slide" id="${options.modal_id}" aria-hidden="true">
			<div class="modal__overlay" tabindex="-1" data-micromodal-close>
				<div id="modal__container" class="${options.class.modal__container}" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
					<main id="${options.id}" class="modal__content ${options.class.modal__content}">
						<div class="loader">
							<div class="d-flex align-items-center justify-content-center">
								<div class="sk-wave">
									<div class="rect1"></div>
									<div class="rect2"></div>
									<div class="rect3"></div>
									<div class="rect4"></div>
									<div class="rect5"></div>
								</div>                    
							</div>
						</div>
					</main>
					<footer class="modal__footer">
					</footer>
				</div>
			</div>
		</div> `;

		return modal;

	}


	this.alert = function(options) {

		//Build alert box
		var alert = `<div class="alert ${options.class} ${options.type}" role="alert">
						${options.message}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>`;

		return alert;

	}

	this.__construct();
}

