var Events = function(){

    this.randomize = function() {
		let num = Date.now()
		
		// If created at same millisecond as previous
		if (num <= this.randomize.previous) {
			num = ++this.randomize.previous
		} else {
			this.randomize.previous = num
		}
		
		return num;
    }
    
    this.populateAgencyList = function(option) {

        var agency_list_container = $(".list-agencies");
       
        var x = 1;

        if(option.data !== null) {
            for (var i = 0; i < option.data.length; i++) {

                events = new Events;
                var uId = events.randomize();
                
                var template = `
                    <tr>             
                        <td class='col-sm-2'>
                            <div class="form-group field-regulatoryordinance-aff_ordinance_id-${uId}">
                                <input type="hidden" id="regulatoryordinance-aff_ordinance_id-${uId}" class="form-control" name="RegulatoryOrdinance[aff_ordinance_id][]" value="${option['data'][i]['id']}">
                                <div class="help-block"></div>
                            </div>                    
                            <div class="form-group field-regulatoryordinance-code-${uId}">
                                <input id="regulatoryordinance-code-${uId}" type="text" class="form-control" name="code" value="${option['data'][i]['ordinance_res_no']}" readonly/>
                                <div class="help-block"></div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group field-regulatoryordinance-title_agency-${uId}">
                                <textarea id="regulatoryordinance-title_agency-${uId}" class="form-control" name="title" rows="5" readonly>${option['data'][i]['title']}</textarea>
                                <div class="help-block"></div>
                            </div>            
                        </td>
                        <td class='agency_level_ordinance_action'>
                            <a class="mb-1 btn btn-sm btn-danger delete" href="#"><i class="mdi mdi-trash-can"></i> Delete</a>       
                        </td>
                    </tr>
                `
                
                $(option.container).append(template);
            
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
                
                x++;
            }   
        }

        agency_list_container.on("click", ".delete", function(e) {
			e.preventDefault();
            $(this).closest("tr").remove();
            x--;
		})	

    }


    this.populateIssuanceList = function(option) {

        var agency_list_container = $(".list-agencies-issuances");
       
        var x = 1;

        if(option.data !== null) {
            for (var i = 0; i < option.data.length; i++) {

                events = new Events;
                var uId = events.randomize();
                
                var template = `
                    <tr>             
                        <td class='col-sm-2'>
                            <div class="form-group field-regulatoryissuance-aff_issuance_id">
                                <input type="hidden" id="regulatoryissuance-aff_issuance_id" class="form-control" name="RegulatoryIssuance[aff_issuance_id][]" value="${option['data'][i]['id']}">
                                <div class="help-block"></div>
                            </div>                   
                            <div class="form-group field-regulatoryissuance-aff_issuance_id-${uId}">
                                <input id="regulatoryissuance-aff_issuance_id-${uId}" type="text" class="form-control" name="code" value="${option['data'][i]['issuance_no']}" readonly/>
                                <div class="help-block"></div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group field-regulatoryissuance-aff_issuance-${uId}">
                                <textarea id="regulatoryissuance-aff_issuance-${uId}" class="form-control" name="title" rows="5" readonly>${option['data'][i]['title']}</textarea>
                                <div class="help-block"></div>
                            </div>            
                        </td>
                        <td class='agency_level_ordinance_action'>
                            <a class="mb-1 btn btn-sm btn-danger delete" href="#"><i class="mdi mdi-trash-can"></i> Delete</a>       
                        </td>
                    </tr>
                `           
                $(option.container).append(template);
        
            }    
            
            agency_list_container.on("click", ".delete", function(e) {
                e.preventDefault();
                $(this).closest("tr").remove();
                x--;
            })                
        }

    }    

    this.populateImpactIssuance = function(option) {

        var issuance_list_container = $(".list-agencies-issuances");
       
        var x = 1;

        console.log(option);

        for (var i = 0; i < option.data.length; i++) {

            events = new Events;
            var uId = events.randomize();

            var template = `
                <tr>
                    <td>
                        <div class="form-group field-regulatoryissuance-stakeholder-${uId}">
                            <input type="hidden" id="regulatoryissuance-stakeholder-${uId}" class="form-control" name="RegulatoryIssuance[issuance_ent_id][]" value="${option.data[i]['issuance_ent_id']}">
                            <div class="help-block"></div>
                        </div>		                    
                        <div class="form-group field-regulatoryissuance-stakeholder-${uId}">
                            <input type="text" id="regulatoryissuance-stakeholder-${uId}" class="form-control" name="RegulatoryIssuance[stakeholder][]" value="${option.data[i]['stakeholder']}">
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
                            <input type="text" id="regulatoryissuance-duration-${uId}" class="form-control" name="RegulatoryIssuance[duration][]" value="${option.data[i]['duration']}">
                            <div class="help-block"></div>
                        </div>	
                    </td>		
                    <td>
                        <a href="#" class="delete">Delete</a>
                    </td>
                </tr>`        
            
            $(option.container).append(template);

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

			for (var key in option['menu']['natureOptions']) {
				natureTemp += `<option value="${key}">${option['menu']['natureOptions'][key]}</option>`	
			}

			//Magnitude
			magnitudeTemp += `<option value="">Select magnitude</option>`;

			for (var key in option['menu']['magnitudeOptions']) {
				magnitudeTemp += `<option value="${key}">${option['menu']['magnitudeOptions'][key]}</option>`	
			}			

			$(natureSel).html(natureTemp);
            $(magnitudeSel).html(magnitudeTemp);

            //Bind value to select
            $(`#regulatoryissuance-nature_id-${uId}`).val(option.data[i]['nature_id']);
            $(`#regulatoryissuance-magnitude_id-${uId}`).val(option.data[i]['magnitude_id']);
                        
            issuance_list_container.on("click", ".delete", function(e) {
                e.preventDefault();
                $(this).closest("tr").remove();
                x--;
            })
        
        }

    }   

    this.readFile = function(fileObject) {
        
        const el = $('.preview-form-regulatory-map');

        //Show progressbar
        el.html(`
             <div id="progress-bar">
                <h5>Reading files....</h5>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>`);

        if(fileObject != undefined) {
            
            var form_data = new FormData();                  
            
            form_data.append('file', fileObject);

            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            percentage = (100 * e.loaded / e.total)
                            $('.progress .progress-bar').css('width', '' +percentage+ '%').attr('aria-valuenow', percentage);
                        };
                    });
                    return xhr;
                },                 
                type: 'POST',
                url: '../file/stash-file',
                contentType: false,
                processData: false,
                data: form_data,
                beforeSend: function() {
                    MicroModal.show('modal-search');
                },
                
                success:function(response) {
                    $.pjax.reload({container: "#uploaded_regulatoy_reforms"});
                    MicroModal.close('modal-search');
                }

            });
        }
    }
    
}