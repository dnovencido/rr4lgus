var Dashboard = function(){
	this.__construct = function(){
		console.log("Dashboard initialized");
		dynamic_field();
	};


	const randomize = () => {
		let num = Date.now()
		
		// If created at same millisecond as previous
		if (num <= randomize.previous) {
			num = ++randomize.previous
		} else {
			randomize.previous = num
		}
		
		return num
	}

	var dynamic_field = function() {
		var max_fields = 10;

		//Container for the input fields
		var agency_list_container = $(".list-agencies");
		//Add button
		var add_button = $(".btn-add-list-agency");	

		var x = 1;
		add_button.click(function(e) {
			e.preventDefault();

			if (x < max_fields) {
				var uId = randomize();

				var template = `
					<div class="row mt-3">
						<div class="col-md-4">
							<div class="form-group field-regulatoryordinance-code-${uId}">
								<input id="regulatoryordinance-code-${uId}" type="text" class="form-control" name="RegulatoryOrdinance[code][]"/>
								<div class="help-block"></div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group field-regulatoryordinance-title_agency-${uId}">
								<input id="regulatoryordinance-title_agency-${uId}" type="text" class="form-control" name="RegulatoryOrdinance[title_agency][]"/>
								<div class="help-block"></div>
							</div>
						</div>
						<a href="#" class="delete">Delete</a>
					</div>`
					
				$(agency_list_container).append(template);

				x++;

			}

			codeConfig = {
                id: `regulatoryordinance-code-${uId}`,
                name: "RegulatoryOrdinance[code][]",
                container: `.field-regulatoryordinance-code-${uId}`,
                input: `#regulatoryordinance-code-${uId}`,
                validate:function (attribute, value, messages, deferred, $form) {
                    yii.validation.required(value, messages, { message: "Code cannot be blank." })
                }
			}
			
			titleConfig = {
                id: `field-regulatoryordinance-title_agency-${uId}`,
                name: "RegulatoryOrdinance[title_agency][]",
                container: `.field-regulatoryordinance-title_agency-${uId}`,
                input: `#regulatoryordinance-title_agency-${uId}`,
                validate:function (attribute, value, messages, deferred, $form) {
                    yii.validation.required(value, messages, { message: "Title cannot be blank." })
                }				
			}

			jQuery('#w0').yiiActiveForm('add', codeConfig);
			jQuery('#w0').yiiActiveForm('add', titleConfig);

		});

		agency_list_container.on("click", ".delete", function(e) {
			e.preventDefault();
			$(this).parent('div').remove();
			x--;
		})	
		
	}
	
	this.__construct();
}

