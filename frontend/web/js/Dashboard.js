var Dashboard = function(){

	this.__construct = function(){
		console.log("Dashboard initialized");
		dynamic_field();
		browse_files();
		drop_zone_file();
		deleteUploadedFile();
		selectAllUploadedFile();
		editFileContent();
		setLabelAs();
		deselectAllUploadedFile();
		selectFile();
		browseListOfAgency();
		selectAgencyLevelOrd();
		browseListOfIssuance();
		selectAgencyLevelIss();
		
	};

	var dynamic_field = function() {
		var max_fields = 10;

		//Container for the input fields
		var agency_list_container = $("#list-impact-values");
		//Add button
		var add_button = $(".btn-add-impact-issuance");	

		var x = 1;
		add_button.click(function(e) {
			e.preventDefault();

			if (x < max_fields) {
				var events = new Events;
				var uId = events.randomize();

				var template = `
					<tr>
						<td>
							<div class="form-group field-regulatoryissuance-stakeholder-${uId}">
								<input type="hidden" id="regulatoryissuance-stakeholder-${uId}" class="form-control" name="RegulatoryIssuance[issuance_ent_id][]" value="${uId}">
								<div class="help-block"></div>
							</div>						
							<div class="form-group field-regulatoryissuance-stakeholder-${uId}">
								<input type="text" id="regulatoryissuance-stakeholder-${uId}" class="form-control" name="RegulatoryIssuance[stakeholder][]">
								<div class="help-block"></div>
							</div>
						</td>
						<td>
							<div class="form-group field-regulatoryissuance-nature_id-${uId}">
								<select id="regulatoryissuance-nature_id-${uId}" class="form-control" name="RegulatoryIssuance[nature_id][]">
								</select>
								<div class="help-block"></div>
							</div>
						</td>
						<td>
							<div class="form-group field-regulatoryissuance-magnitude_id-${uId}">
								<select id="regulatoryissuance-magnitude_id-${uId}" class="form-control" name="RegulatoryIssuance[magnitude_id][]">
								</select>
								<div class="help-block"></div>
							</div>						
						</td>
						<td>
							<div class="form-group field-regulatoryissuance-duration-${uId}">
								<input type="text" id="regulatoryissuance-duration-${uId}" class="form-control" name="RegulatoryIssuance[duration][]">
								<div class="help-block"></div>
							</div>	
						</td>		
						<td>
							<a href="#" class="delete">Delete</a>
						</td>
					</tr>`
					
				$(agency_list_container).append(template);

				x++;

			}

			//Select2
			$(`.field-regulatoryissuance-nature_id`).find('option').clone().appendTo(`#regulatoryissuance-nature_id-${uId}`);
			$(`.field-regulatoryissuance-magnitude_id`).find('option').clone().appendTo(`#regulatoryissuance-magnitude_id-${uId}`);		


			//Add selection for nature & magnitude
			var natureSel = $(`#regulatoryissuance-nature_id-${uId}`);
			var magnitudeSel = $(`#regulatoryissuance-magnitude_id-${uId}`);

			var natureTemp = '';
			var magnitudeTemp = '';

			//Nature
			natureTemp += `<option value="">Select nature</option>`;

			for (var key in listMenu['natureOptions']) {
				natureTemp += `<option value="${key}">${listMenu['natureOptions'][key]}</option>`	
			}

			//Magnitude
			magnitudeTemp += `<option value="">Select magnitude</option>`;

			for (var key in listMenu['magnitudeOptions']) {
				magnitudeTemp += `<option value="${key}">${listMenu['magnitudeOptions'][key]}</option>`	
			}			

			$(natureSel).html(natureTemp);
			$(magnitudeSel).html(magnitudeTemp);
				
			stakeholderConfig = {
                id:  `field-regulatoryissuance-stakeholder-${uId}`,
                name: "RegulatoryOrdinance[stakeholder][]",
                container: `.field-regulatoryissuance-stakeholder-${uId}`,
                input: `#regulatoryissuance-stakeholder-${uId}`,
                validate:function (attribute, value, messages, deferred, $form) {
                    yii.validation.required(value, messages, { message: "Stakeholder cannot be blank." })
                }
			}

			//Add validations
			jQuery('#w0').yiiActiveForm('add', stakeholderConfig);

		});

		
		agency_list_container.on("click", ".delete", function(e) {
			e.preventDefault();
			$(this).closest("tr").remove();
			x--;
		})	
		
	}

	var browse_files = function() {

		$('body').on('click','#select-file', function(){
			document.getElementById('selectfile').click();
			
			document.getElementById('selectfile').onchange = function() {
				fileobj = document.getElementById('selectfile').files[0];
				
				var event = new Events();
				event.readFile(fileobj);

			};

		})		  
	}

	var drop_zone_file = function() {
		$('#drop_file_zone').on('dragover', false) 
		.on('drop', function (e) {
			return false;
		});
	}

	var selectFile = function() {
		$('body').on('change', 'input[name="selection[]"]' , function() {
			if($('input[name="selection[]"]:checked').length > 0) {
				$('#set-label').removeClass('disabled');
				$('#delete-selection').removeClass('disabled');
			}
		});
	}

	var deselectAllUploadedFile = function() {
		$('body').on('click', '#uncheck-all-selection', function(e){
			e.preventDefault();

			$('input[name="selection[]"]').prop("checked", false);

			$('#check-all-selection').css('display', 'block');
			$('#uncheck-all-selection').css('display', 'none');

			if($('input[name="selection[]"]:checked').length == 0) {
				$('#set-label').addClass('disabled');
				$('#delete-selection').addClass('disabled');
			}

		});
	}

	var selectAllUploadedFile = function() {
		$('body').on('click', '#check-all-selection', function(e){
			e.preventDefault();

			$('input[name="selection[]"]').prop("checked", true);

			$('#check-all-selection').css('display', 'none');
			$('#uncheck-all-selection').css('display', 'block');

			if($('input[name="selection[]"]:checked').length > 0) {
				$('#set-label').removeClass('disabled');
				$('#delete-selection').removeClass('disabled');
			}
			
		});
	}

	var deleteUploadedFile = function() {
		$('#delete-selection').click(function(e){
			e.preventDefault();
		})
	}

	var editFileContent = function() {
		$('body').on('click', '.btn-update-file-content', function(e){
			e.preventDefault();

			var render= new Render();
			var targetElement = $('.modal-st');

			//Render modal
			var options = {
				modal_id: 'modal-file-content',
				id : 'file-content',
				class: {
					modal__container : 'modal__container_file_content',
					modal__content : 'modal__content_file_content'
				}
			}

			var modal = render.modal(options);
			targetElement.html(modal);

			//Show modal
			MicroModal.show(options.modal_id);

			//Initialize slim scroll;
			$('#modal__container').slimScroll({
				height: '650px'
			});

			var dataId = $(this).closest("tr").attr("data-key");

			$('#file-content').load($(this).attr('value'), function() {

				//Submit form
				$('body').on('submit','#w0', function(ev){ 

					ev.preventDefault();

					var data = $(this).serializeArray();
					var url = $(this).attr('action');

					$.ajax({
						url: url,
						type: 'post',
						dataType: 'json',
						data: data
					})

					.done(function(response) {
						
						if(response.status !== 0) {
							$('tr[data-key='+response.id+']').addClass('table-info');
						
							//Render updated policy_code_no, title and type;
							$('tr[data-key='+response.id+'] td:nth-child(3)').html(response.policy_code_no);
							$('tr[data-key='+response.id+'] td:nth-child(4)').html(response.title);
							$('tr[data-key='+response.id+'] td:nth-child(5)').html(response.type);
						} 

						MicroModal.close('modal-file-content');

					})

					.fail(function() {
						alert("There was an error updating record...");
					});

				});	

			});
			
		});
	}

	var setLabelAs = function() {
		$('body').on('click', '#set-label', function(e){
			e.preventDefault();

			let arraySel = [];

			$('input[name="selection[]"]:checked').each(function(i){
				arraySel[i] = $(this).val();
			});

			var url = yiiOptions.baseUrl + '/regulatory-map/set-label';
			var valueLabel = String($('#set-label').attr('value'));

			
			var data = {
				regulatory_id : arraySel,
				status : valueLabel
			}

			$.ajax({
				url: url,
				type: 'post',
				dataType: 'json',
				data: data
			})

			.done(function(response) {

				if(response !== null) {
					var render= new Render();
					var alertElement = $('.alert-box');
	
					var growlOptions = { title: '<b><i class="mdi mdi-check-outline"></i> Successfully</b>', message: 'labeled as verified entry.', showSeparator: true};
				
					var growlSettings = { placement: { from: "top", align: "right"}, type: 'success', }; 
					
					$.notify(growlOptions, growlSettings);
					 
					$.pjax.reload({container: "#uploaded-file-content"});
				}

			})

			.fail(function() {
				
			});		

		});
	}

	var browseListOfAgency = function() {

		$('body').on('click', '.btn-browse-list-agency', function(e) {
			e.preventDefault();

			var render= new Render();
			var targetElement = $('.modal-ro');

			//Render modal
			var options = {
				modal_id : 'browse_list_agency',
				id : 'browse_list_agency_content',
				class: {
					modal__container : 'modal__container modal__container_browse_list_agencies',
					modal__content : 'modal__content_browse_list_agencies'
				}
			}

			var modal = render.modal(options);
			targetElement.html(modal);

			//Show modal
			MicroModal.show(options.modal_id);		
			
			$('#browse_list_agency_content').load($(this).attr('value'), function() {
				//Initialize slim scroll;
				$('#modal__container').slimScroll({
					height: '650px'
				});	

			});

		});
	}

	var selectAgencyLevelOrd = function() {
		$('body').on('click', '#choose-ordinance', function(){

			let arraySelAgency = [];

			//Get selected ordinance from modal
			$('input[name="selection[]"]:checked').each(function(i){
				arraySelAgency[i] = $(this).val();
			});		

			var url = yiiOptions.baseUrl + '/ordinance/list-by-id';

			var data = {
				id : arraySelAgency
			}

			$.ajax({
				url: url,
				type: 'post',
				dataType: 'json',
				data: data
			})

			.done(function(response) {

				var option = {
					data : response,
					container: $('#list-agency-values')
				};
				
				var events = new Events();
				//Populate agencylist
				events.populateAgencyList(option);

				MicroModal.close('browse_list_agency');		

			})

			.fail(function() {
				
			});	
		})
	}

	var browseListOfIssuance = function() {

		$('body').on('click', '.btn-browse-list-agency-issuance', function(e) {
			e.preventDefault();
			
			var render= new Render();
			var targetElement = $('.modal-ri');

			//Render modal
			var options = {
				modal_id : 'browse_list_issuance',
				id : 'browse_list_issuance_content',
				class: {
					modal__container : 'modal__container modal__container_browse_list_issuance',
					modal__content : 'modal__content_browse_list_issuance'
				}
			}

			var modal = render.modal(options);
			targetElement.html(modal);

			//Show modal
			MicroModal.show(options.modal_id);		

			$('#'+options.id).load($(this).attr('value'), function() {
				//Initialize slim scroll;
				$('.grid-view').slimScroll({
					height: '650px'
				});	

			});

		});
	}	

	var selectAgencyLevelIss = function() {
		$('body').on('click', '#choose-issuance', function(){

			let arraySelIssuance = [];

			//Get selected ordinance from modal
			$('input[name="issuance[]"]:checked').each(function(i){
				arraySelIssuance[i] = $(this).val();
			});		

			var url = yiiOptions.baseUrl + '/issuance/list-by-id';

			var data = {
				id : arraySelIssuance
			}


			$.ajax({
				url: url,
				type: 'post',
				dataType: 'json',
				data: data
			})

			.done(function(response) {

				var option = {
					data : response,
					container: $('#list-issuance-values')
				};
				
				var events = new Events();

				//Populate agencylist
				events.populateIssuanceList(option);

				MicroModal.close('browse_list_agency');		

			})

			.fail(function() {
				
			});	
		})
	}

	
	this.__construct();
}

