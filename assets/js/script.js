
var baseUrl= "http://localhost:8080/freelancing/magazine";

$(window).on('load',function(){
	var containers = $('.double-article'),
		size = containers.length,
		i =  size - 1,
		j = 0;
	while (i >=j ){
		if(i==j)
			break;
		else{
			containers.eq(j).append(containers.eq(i).html());
			containers.eq(i).remove();
			j++;
			i--;
		}
	}

	var doubleArticles = $('.double-article');
	for(var i = 0; i < doubleArticles.length; i++){
		var articles = doubleArticles.eq(i).children('div');
		if(articles.eq(0).hasClass('article-type-4') && articles.eq(1).hasClass('article-type-4')){
			//console.log(articles.eq(0));
			articles.eq(0).css('width','47.5%');
			articles.eq(1).css('width','47.5%').css('margin-right','5%');
		}
		else if(articles.eq(0).hasClass('article-type-3') && articles.eq(1).hasClass('article-type-3')){
			articles.eq(0).css('width','47.5%').css('margin-right','5%');
			articles.eq(1).css('width','47.5%');
		}
	}
});




(function(){
	// HIDE ALL BUTTONS WITH CLASS submit-btn
	$('.submit-btn').hide();


	

	// DISABLE SUBMITTING FORM ON PRESSING ENTER
	$('form input').on('keyup keypress',function(e){
		if(e.which == 13){
			e.preventDefault();
		}
	});




	// TOGGLE SIDEBAR MENU IN SMALL SCREENS
	var navigationMenu = $('.navigation-menu');
	$('.menu-bars').on('click',function(){
		$('#body-overlay').fadeIn(500);
		navigationMenu.animate({
			'margin-right' : '0px'
		},500);
		navigationMenu.addClass('is-showing');
	});

	$('#body-overlay').on('click',function(){
		$(this).fadeOut(500);
		navigationMenu.animate({
			'margin-right' : '-230px'
		},500);
		navigationMenu.removeClass('is-showing');
	});

	$(window).on('resize',function(){
		if($(window).width() > 991){
			$('.navigation-menu').css('margin-right','0');
		}
		else{
			if(!$('.navigation-menu').hasClass('is-showing')){
				$('.navigation-menu').css('margin-right','-230px');	
			}
		}
	});




	// TOOLTIP
	$('[data-toggle="tooltip"]').tooltip();




	// ACCOUNTS MENU DROPDOWN ON THE ARROW IS CLICKED
	var accountsMenu = $('.accounts-drop-down');
	$(document).on('click',function(e){
	    if(!$(e.target).closest('#accounts-menu-trigger').length)	accountsMenu.slideUp(150);
    	else accountsMenu.slideToggle(150);        
	});




	// SUBSCRIPTION
	$('#subscribe-user').on('submit',function(e){
		e.preventDefault();
		$('#status-msg').empty().append("Please wait &nbsp;<i class='fa fa-spinner fa-spin'></i>");
		$.ajax({
			url : baseUrl + '/assets/functions/process-forms.php',
			method : 'post',
			data : { subscriber_email : $('#subscriber-email').val(), saveSubscriberEmail : true },
			success : function(context){
				console.log(context);
				$('#status-msg').empty().append(context);
			} 
		});
	});



	// PREFERENCE CENTER
	$('.preference-section button').on('click',function(){
		var $this = $(this), 
			preferenceBox = $this.closest('.preference-section').children('.preference-box'),
			preferenceBoxHtml = preferenceBox.html(),
			el = $this.parent('div').siblings('.preference-box'),
			value = $this.siblings('.preferred-items').val(),
			item = "";
		
		if(!inBox(el,value)){		
			if($this.siblings('.preferred-items').attr('id') == "map-locations")
				item = "<span style='margin-left:5px;' data-attribute='" + $this.siblings('.preferred-items').val() + "'>" + $this.siblings('.preferred-items').val() + " <i class='fa fa-times-circle'></i></span>";
			else
				item = "<span style='margin-left:5px;' data-attribute='" + $this.siblings('.preferred-items').val() + "'>" + $this.siblings('.preferred-items').find(':selected').text() + " <i class='fa fa-times-circle'></i></span>";
			preferenceBox.append(item);		
		}
		allowRemovingPreference();
	});
	allowRemovingPreference();




	// TRIGGER BUTTON WHEN ENTER IS PRESSED
	$('.preference-section select , preference-section input').on('keypress',function(e){
		if(e.which == 13){
			$(this).next('button').trigger('click');
		}
	});




	// SAVE PREFERENCE CENTER
	$('#save-preference-center').on('click',function(){
		var countryLanguages = languages = categories = locations = "";
		$('#language-textarea span').each(function(){
			countryLanguages += '#$#' + $(this).text();
			languages += '#$#' + $(this).data('attribute');
		});
		$('#category-textarea span').each(function(){
			categories += '#$#' + $(this).text();
		});
		$('#location-textarea span').each(function(){
			locations += '#$#' + $(this).text();
		});
		countryLanguages = countryLanguages.substr(3);
		languages = languages.substr(3);
		categories = categories.substr(3);
		locations = locations.substr(3);
		$.ajax({
			url : baseUrl + '/assets/functions/process-forms.php',
			method : 'post',
			data : { countryLanguages : countryLanguages, languages : languages, categories : categories, locations : locations, preferenceCenter : true },
			success : function(context){
				console.log(context);
			}
		});
	});




	// CHANGE ARTICLE LANGUAGE WHEN A FLAG IS CLICKED
	var languages = $('.language-availability .flag');
	languages.on('mouseenter',function(){$(this).css('cursor','pointer');});
	languages.on('click',function(){
		var $this = $(this),
			translationBox = $this.closest('.article').find('.different-language-translation');

		translationBox.show();
		$.ajax({
			url : baseUrl + '/assets/functions/process-forms.php',
			method : 'get',
			dataType : 'json',
			data : {articleId : $this.closest('.this-article').data('article'), language : $this.data('language')},
			success : function(context){
				translationBox.hide();
				var hashtags = context.ARTICLE_HASHTAGS,
					parts = hashtags.split(",");
				hashtags = "";
				if(parts.length>1){
					for(var i=0; i<parts.length; i++){
						hashtags += "<em>#" + $.trim(parts[i]) + "</em>";
					}	
				}
				var body = context.ARTICLE_BODY,
					parts = body.split("&lt;/p&gt;&lt;p&gt;");
				body = "";
				for(var i=0; i<parts.length; i++){
					body += $.trim(parts[i]);
				}
				$this.closest('.this-article').find('h1 a').text(context.ARTICLE_TITLE);
				$this.closest('.this-article').find('.this-article-text p').first().text(body.substr(0,142));
				$this.closest('.this-article').find('.hashtags').empty().append(hashtags);
			}
		});
	});




	// EDITOR REVIEW PAGE
	var languages = $('.language-availability .flag');
	languages.on('mouseenter',function(){$(this).css('cursor','pointer');});
	languages.on('click',function(){
		var $this = $(this);
		$.ajax({
			url : baseUrl + '/assets/functions/process-forms.php',
			method : 'get',
			dataType : 'json',
			data : {articleId : $this.closest('.this-article').data('article'), language : $this.data('language')},
			success : function(context){
				$this.closest('.this-article').find('.this-title').text(context.ARTICLE_TITLE);
			}
		});
	});


	// ARTICLE DETAIL PAGE
	var languages = $('.flags .flag');
	languages.on('click',function(){
		var $this = $(this);
		$.ajax({
			url : baseUrl + '/assets/functions/process-forms.php',
			method : 'get',
			dataType : 'json',
			data : {articleId : $this.closest('.article-detail').data('article'), language : $this.data('language')},
			success : function(context){
				var hashtags = context.ARTICLE_HASHTAGS,
					parts = hashtags.split(",");
				hashtags = "";
				if(parts.length>1){
					for(var i=0; i<parts.length; i++){
						hashtags += "<em>#" + $.trim(parts[i]) + "</em>";
					}	
				}
				var body = context.ARTICLE_BODY,
					parts = body.split("&lt;/p&gt;&lt;p&gt;");
				body = "";
				for(var i=0; i<parts.length; i++){
					body += $.trim(parts[i]) + "</p><p>";
				}
				body = "<p>" + body;
				$('.main-title').text(context.ARTICLE_TITLE);
				$this.closest('.article-detail').find('.article-text').empty().append(body);
				$this.closest('.article-detail').find('.article-hashtags').empty().append(hashtags);
			}
		});
	});




	// INSERT A NEW TRANSLATION BOX AT THE END OF THE FORM
	$('.add-translation-box').on('click',function(){
		/* DIV FORMAT (TRANSLATION BOX) TO APPEND ON THE FORM WHEN ADD NEW TRANSLATION BOX IS CLICKED
		<div class="form-inputs col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<label>Choose Language</label>
			<button type="button" onclick="deleteTranslationBox(this);" class="btn btn-default remove-translated-article"><i class="fa fa-trash"></i></button>
			<select class="languages">
				<option value="">Choose Language</option>
				<option value="..">.....</option>
			</select>
			<input type="text" class="form-control article-title" placeholder="Article Title">
			<input type="text" class="form-control article-hashtags" placeholder="Hastags (comma separated)">
			<textarea class="form-control article-body" placeholder="Write down your article"></textarea>
		</div> <!-- /form-inputs -->
		*/

		var countryList = getCountries();
		var translationBox = "<div class='form-inputs col-lg-6 col-md-6 col-sm-6 col-xs-12'><label>Choose Language</label><button type='button' onclick='deleteTranslationBox(this);' class='btn btn-default remove-translated-article'><i class='fa fa-trash'></i></button><select class='languages' name='languages[]' onchange='languageChoice(this);' required><option value=''>Choose Language</option>" + countryList + "</select><input type='text' name='titles[]' class='form-control article-title' placeholder='Article Title' required><input type='text' name='hashtags[]' class='form-control article-hashtags' placeholder='Hastags (comma separated)'><textarea name='descriptions[]' class='form-control article-body' placeholder='Write down your article' required></textarea></div>";
		$(translationBox).insertBefore('#form-submit-info');
	});	




	// TOGGLE LINK AND TAG/INPUT FIELD ON NEW ARTICLE PAGE WHEN ADD LINK/ADD TAG BUTTON IS CLICKED	
	// $('#show-tags').on('click',function(){
	// 	$('#tags').show();
	// });
	$('#show-link').on('click',function(){
		$('#link').show();
	});
	// $('#hide-tags').on('click',function(){
	// 	$('#tags').hide();
	// });
	$('#hide-link').on('click',function(){
		$('#link').hide();
	});




	// PREVIEW IMAGE BEFORE UPLOADING
	var previewing = "img";
	$('.file-input').on('click',function(){
		if($(this).hasClass('img')) previewing = "img";
		else if($(this).hasClass('vid')) previewing = "vid";
	});

	$('#file-input').on('change',function(){
		if($(this).val() != ""){
			var file = $("#file-input"),
				fileName = file.val(),
				extension = fileName.substr(fileName.lastIndexOf('.') + 1),
				allow = false;

			if(previewing == "img"){
				// VALIDATE IMAGE EXTENSION
				var allowedExtensions = ["jpg","jpeg","png","gif","tif","bmp"];
				for(var i=0; i<allowedExtensions.length; i++){
					if(extension.toLowerCase() == allowedExtensions[i]){
						allow = true;
						break;
					}
				}
				if(allow == true){
					if(file[0].files[0].size <= 10000000){
						$('#type').val('img');
						$('#link-preview').empty().hide();
						$('#link-input').val('').parent('#link').hide();
						$('.previews').hide();
						previewImg(this,"preview-img");
					}
					else{
						$('.dialog-content h3').text('Whoops!!');
						$('.dialog-content p').text('Looks like the image is a big one. Maximum image size can be 10MB. The image you are trying to upload has larger size');
						$('#dialog-box').fadeIn();
					}
				}
				else{
					$('.dialog-content h4').text('Whoops!!');
					$('.dialog-content p').text('Please choose an image of one of the following extensions : jpg, jpeg, png, gif, tif, bmp. The image you are trying to upload has .' + extension + ' extension');
					$('#dialog-box').fadeIn();
				}
			}

			else if(previewing == "vid"){
				// VALIDATE VIDEO EXTENSION
				var allowedExtensions = ["mp4","webm","ogg"];
				for(var i=0; i<allowedExtensions.length; i++){
					if(extension.toLowerCase() == allowedExtensions[i]){
						allow = true;
						break;
					}
				}
				if(allow == true){
					if(file[0].files[0].size <= 50000000){
						$('#type').val('vid');
						$('#link-preview').empty().hide();
						$('#link-input').val('').parent('#link').hide();
						$('.previews').hide();
						var source = $('#preview-video').children('source');
						source[0].src = URL.createObjectURL(this.files[0]);
						source.parent()[0].load();	
						source.parent('video').fadeOut('fast').fadeIn('slow');
						//URL.revokeObjectURL(source[0].src);
					}
					else{
						$('.dialog-content h4').text('Whoops!!');
						$('.dialog-content p').text('Looks like the video is a big one. Maximum video size can be 50MB. The video you are trying to upload has larger size');
						$('#dialog-box').fadeIn();
					}
				}
				else{
					$('.dialog-content h4').text('Whoops!!');
					$('.dialog-content p').text('Please choose an video of one of the following extensions : mp4, ogg, webm. The video you are trying to upload has .' + extension + ' extension');
					$('#dialog-box').fadeIn();
				}
			}
		}
	});
	// DIALOG BOX DISAPPER WHEN THE BUTTON INSIDE THE DIALOG IS CLICKED
	$('#dialog-box button').on('click',function(){
		$(this).closest('#dialog-box').fadeOut();
	});




	// SET STATUS VALUE WHEN EDITOR IS LOGGED IN AND SAVE BUTTON IS CLICKED
	$('#save-article').on('click',function(){
		$('#status-val').val("0");
		$('.save-article').trigger('click');
	});
	$('#publish-article').on('click',function(){
		$('#status-val').val("1");
		$('.publish-article').trigger('click');
	});


	
	$('#link-input').on('keyup',function(){
		if($(this).val() != ""){
			$.ajax({
				url : baseUrl + '/assets/functions/process-forms.php',
				method : 'post',
				data : { url : $(this).val(), crawl : 'true'},
				success : function(context){
					$('.previews').hide();
					$('#link-preview').empty().append(context).fadeIn();
					$('#file-input').val('');
					$('#type').val('link');
				}
			});
		}
		else{
			$('#link-preview').empty().hide();
			$('#type').val('');
		}
	});




	// INSTANTANEOUS REVIEW PAGE SEARCH BOX
    var activeSystemClass = $('.list-group-item.active');
    //something is entered in search form
    $('#system-search').keyup( function() {
       var that = this;
        // affect all table rows on in systems table
        var tableBody = $('.table-list-search tbody');
        var tableRowsClass = $('.table-list-search tbody tr');
        $('.search-sf').remove();
        tableRowsClass.each( function(i, val) {
	        //Lower text for case insensitive
	        var rowText = $(val).text().toLowerCase();
	        var inputText = $(that).val().toLowerCase();
	        if(inputText != ''){
	            $('.search-query-sf').remove();
	            tableBody.prepend('<tr class="search-query-sf"><td colspan="6"><strong>Searching for: "'
	                + $(that).val()
	                + '"</strong></td></tr>');
	        }
            else{
                $('.search-query-sf').remove();
            }
			 if( rowText.indexOf( inputText ) == -1 ){
                //hide rows
                tableRowsClass.eq(i).hide();
            }
            else{
                $('.search-sf').remove();
                tableRowsClass.eq(i).show();
            }
        });
        //all tr elements are hidden
        if(tableRowsClass.children(':visible').length == 0){
            tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="6">No entries found.</td></tr>');
        }
    });




	// RE-SEND ACCOUNT VERIFICATION E-MAIL
	$('#retrieve-email').on('click', function(){
		var spinner = $(this).siblings('.fa-spinner');
		spinner.removeClass('hidden');
		$.ajax({
			url : '../../assets/functions/process-forms.php',
			method : 'post',
			data : { retriveEmail : true },
			success : function(result){
				spinner.addClass('hidden');
				if(result == "true"){
					$('.dialog-content').children('h4').text('Verification Link');
					$('.dialog-content').children('p').text('We have re-sent you the verification link to activate your account. Please check your e-mail').css('color','#337ab7');
					$('#dialog-box').fadeIn();
				}
				else{
					$('.dialog-content').children('h4').text('Error');
					$('.dialog-content').children('p').text('Something went wrong. Please try again later').css('color','red');
					$('#dialog-box').fadeIn();
				}
			}
		});
	});




	$('#preview-article').on('click',function(){
		var type = $('#tile-type').val();
		if(type != ""){
			var url = '../../preview/?article=' + $('#article-id').val() + "&type=" + type;
			window.open(url, '_blank');
		}
		else{
			$('.tile-type').append("<label class='red'>Choose A Display Option First</label>");
		}
	});

})();




function languageChoice(el){
	// SET Language NAME AS THE LABEL TEXT WHEN THE LANGUAGE CHOICE SELECT BOX VALUE IS SELECT
	var $this = $(el);
	if($this.val() != ""){
		$this.siblings('label').text("Language : " + $this.find('option:selected').text());	
	}
	else{
		$this.siblings('label').text("Choose Language");	
	}
	appendFlags();
}




function deleteTranslationBox(el){
	// REMOVE TRANSLATION BOX WHEN TRASH SIGN IS CLICKED
	if(confirm('Are you sure about deleting this translation section?')){
		el.closest('.form-inputs').remove();
		appendFlags();
	}
}




function appendFlags(){
	var languages = "";
	$('.languages').each(function(){
		if($(this).val() != ""){
			languages += "<span class='flag flag-" + $(this).val() + "'></span>";
		}
	});
	$('.all-flags').empty().append(languages);
}




function previewImg(input,id) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
	    reader.onload = function(e) {
	    	$('#' + id).attr('src', e.target.result).fadeOut('fast').fadeIn('slow');
	    }
    	reader.readAsDataURL(input.files[0]);
	}
}




function getCountries(){
	var countries = "<optgroup label='Africa'><option value='dz'>Algeria</option><option value='ao'>Angola</option><option value='bj'>Benin</option><option value='bw'>Botswana</option><option value='bf'>Burkina Faso</option><option value='bi'>Burundi</option><option value='cm'>Cameroon</option><option value='cv'>Cape Verde</option><option value='cf'>Central African Republic</option><option value='td'>Chad</option><option value='km'>Comoros</option><option value='cg'>Congo</option><option value='ci'>Cote d'Ivoire</option><option value='dj'>Djibouti</option><option value='eg'>Egypt</option><option value='gq'>Equatorial Guinea</option><option value='er'>Eritrea</option><option value='et'>Ethiopia</option><option value='ga'>Gabon</option><option value='gm'>Gambia</option><option value='gh'>Ghana</option><option value='gn'>Guinea</option><option value='gw'>Guinea-Bissau</option><option value='ke'>Kenya</option><option value='ls'>Lesotho</option><option value='lr'>Liberia</option><option value='ly'>Libya</option><option value='mg'>Madagascar</option><option value='mw'>Malawi</option><option value='ml'>Mali</option><option value='mr'>Mauritania</option><option value='mu'>Mauritius</option><option value='yt'>Mayotte</option><option value='ma'>Morocco</option><option value='mz'>Mozambique</option><option value='na'>Namibia</option><option value='ne'>Niger</option><option value='ng'>Nigeria</option><option value='re'>Reunion</option><option value='rw'>Rwanda</option><option value='sh'>Saint Helena</option><option value='st'>Sao Tome</option><option value='sn'>Senegal</option><option value='sc'>Seychelles</option><option value='sl'>Sierra Leone</option><option value='so'>Somalia</option><option value='za'>South Africa</option><option value='sd'>Sudan</option><option value='sz'>Swaziland</option><option value='tz'>Tanzania</option><option value='tg'>Togo</option><option value='tn'>Tunisia</option><option value='ug'>Uganda</option><option value='eh'>Western Sahara</option><option value='zm'>Zambia</option><option value='zw'>Zimbabwe</option></optgroup><optgroup label='America'><option value='ai'>Anguilla</option><option value='ag'>Antigua and Barbuda</option><option value='ar'>Argentina</option><option value='aw'>Aruba</option><option value='bs'>Bahamas</option><option value='bb'>Barbados</option><option value='bz'>Belize</option><option value='bm'>Bermuda</option><option value='bo'>Bolivia</option><option value='br'>Brazil</option><option value='ca'>Canada</option><option value='ky'>Cayman Islands</option><option value='cl'>Chile</option><option value='co'>Colombia</option><option value='cr'>Costa Rica</option><option value='cu'>Cuba</option><option value='dm'>Dominica</option><option value='do'>Dominican Republic</option><option value='ec'>Ecuador</option><option value='sv'>El Salvador</option><option value='fk'>Falkland Islands</option><option value='gf'>French Guiana</option><option value='gl'>Greenland</option><option value='gd'>Grenada</option><option value='gp'>Guadeloupe</option><option value='gt'>Guatemala</option><option value='gy'>Guyana</option><option value='ht'>Haiti</option><option value='hn'>Honduras</option><option value='jm'>Jamaica</option><option value='mq'>Martinique</option><option value='mx'>Mexico</option><option value='ms'>Montserrat</option><option value='an'>Netherlands Antilles</option><option value='ni'>Nicaragua</option><option value='pa'>Panama</option><option value='py'>Paraguay</option><option value='pe'>Peru</option><option value='pr'>Puerto Rico</option><option value='bl'>Saint Barthelemy</option><option value='kn'>Saint Kitts and Nevis</option><option value='lc'>Saint Lucia</option><option value='mf'>Saint Martin</option><option value='pm'>Saint Pierre and Miquelon</option><option value='vc'>Saint Vincent and the Grenadines</option><option value='sr'>Suriname</option><option value='tt'>Trinidad and Tobago</option><option value='tc'>Turks and Caicos Islands</option><option value='us'>United States</option><option value='uy'>Uruguay</option><option value='ve'>Venezuelaf</option><option value='vg'>Virgin Islands, British</option><option value='vi'>Virgin Islands, U.S.</option></optgroup><optgroup label='Asia'><option value='af'>Afghanistan</option><option value='am'>Armenia</option><option value='az'>Azerbaijan</option><option value='bh'>Bahrain</option><option value='bd'>Bangladesh</option><option value='bt'>Bhutan</option><option value='bn'>Brunei Darussalam</option><option value='kh'>Cambodia</option><option value='cn'>China</option><option value='cy'>Cyprus</option><option value='ge'>Georgia</option><option value='hk'>Hong Kong</option><option value='in'>India</option><option value='id'>Indonesia</option><option value='ir'>Iran</option><option value='iq'>Iraq</option><option value='il'>Israel</option><option value='jp'>Japan</option><option value='jo'>Jordan</option><option value='kz'>Kazakhstan</option><option value='kp'>Korea</option><option value='kr'>Korea</option><option value='kw'>Kuwait</option><option value='kg'>Kyrgyzstan</option><option value='la'>Lao</option><option value='lb'>Lebanon</option><option value='mo'>Macao</option><option value='my'>Malaysia</option><option value='mv'>Maldives</option><option value='mn'>Mongolia</option><option value='mm'>Myanmar</option><option value='np'>Nepal</option><option value='om'>Oman</option><option value='pk'>Pakistan</option><option value='ps'>Palestinian Territo</option><option value='ph'>Philippines</option><option value='qa'>Qatar</option><option value='sa'>Saudi Arabia</option><option value='sg'>Singapore</option><option value='lk'>Sri Lanka</option><option value='sy'>Syrian</option><option value='tw'>Taiwan</option><option value='tj'>Tajikistan</option><option value='th'>Thailand</option><option value='tl'>Timor-Leste</option><option value='tr'>Turkey</option><option value='tm'>Turkmenistan</option><option value='ae'>UAE</option><option value='uz'>Uzbekistan</option><option value='vn'>Vietnam</option><option value='ye'>Yemen</option></optgroup><optgroup label='Europe'><option value='ax'>Aland Islands</option><option value='al'>Albania</option><option value='ad'>Andorra</option><option value='at'>Austria</option><option value='by'>Belarus</option><option value='be'>Belgium</option><option value='ba'>Bosnia and Herzegovina</option><option value='bg'>Bulgaria</option><option value='hr'>Croatia</option><option value='cz'>Czech Republic</option><option value='dk'>Denmark</option><option value='ee'>Estonia</option><option value='fo'>Faroe Islands</option><option value='fi'>Finland</option><option value='fr'>France</option><option value='de'>Germany</option><option value='gi'>Gibraltar</option><option value='gr'>Greece</option><option value='gg'>Guernsey</option><option value='va'>Holy See</option><option value='hu'>Hungary</option><option value='is'>Iceland</option><option value='ie'>Ireland</option><option value='it'>Italy</option><option value='je'>Jersey</option><option value='lv'>Latvia</option><option value='li'>Liechtenstein</option><option value='lt'>Lithuania</option><option value='lu'>Luxembourg</option><option value='mk'>Macedonia</option><option value='mt'>Malta</option><option value='md'>Moldova</option><option value='mc'>Monaco</option><option value='me'>Montenegro</option><option value='nl'>Netherlands</option><option value='no'>Norway</option><option value='pl'>Poland</option><option value='pt'>Portugal</option><option value='ro'>Romania</option><option value='ru'>Russian Federation</option><option value='sm'>San Marino</option><option value='rs'>Serbia</option><option value='sk'>Slovakia</option><option value='si'>Slovenia</option><option value='es'>Spain</option><option value='sj'>Svalbard and Jan Mayen</option><option value='se'>Sweden</option><option value='ch'>Switzerland</option><option value='ua'>Ukraine</option><option value='gb'>United Kingdom</option></optgroup><optgroup label='Australia and Oceania'><option value='as'>American Samoa</option><option value='au'>Australia</option><option value='ck'>Cook Islands</option><option value='fj'>Fiji</option><option value='pf'>French Polynesia</option><option value='gu'>Guam</option><option value='ki'>Kiribati</option><option value='mh'>Marshall Islands</option><option value='fm'>Micronesia</option><option value='nr'>Nauru</option><option value='nc'>New Caledonia</option><option value='nz'>New Zealand</option><option value='nu'>Niue</option><option value='nf'>Norfolk Island</option><option value='mp'>Northern Mariana Islands</option><option value='pw'>Palau</option><option value='pg'>Papua New Guinea</option><option value='pn'>Pitcairn</option><option value='ws'>Samoa</option><option value='sb'>Solomon Islands</option><option value='tk'>Tokelau</option><option value='to'>Tonga</option><option value='tv'>Tuvalu</option><option value='vu'>Vanuatu</option><option value='wf'>Wallis and Futuna</option></optgroup><optgroup label='Other areas'><option value='bv'>Bouvet Island</option><option value='io'>British Indian Ocean</option><option value='eu'>European Union</option><option value='tf'>French Southern Territory</option><option value='hm'>Heard Island</option><option value='gs'>South Georgi</option><option value='um'>United States Minor</option></optgroup>";
	return countries;
}




function inBox(element,value){
	var found = false;
	element.find('span').each(function(){
		if($(this).data('attribute') == value){
			found = true;
		}
	});
	return found;
}
	



function allowRemovingPreference(){
	$('.preference-box .fa-times-circle').on('click',function(){
		$(this).parent('span').remove();
	});
}




function activatePlacesSearch(){
	var input = document.getElementById('map-locations');
	var autoComplete = new google.maps.places.Autocomplete(input);
}




async function wait(time){
	await sleep(time);
}




function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}