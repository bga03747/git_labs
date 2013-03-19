	/*
	Jquery Multi-friend selector beta 1.1
	
	Note: to use this, you need to pass an array of users, 

	array(array( "id" => "fb id", "name" => "Name of fb user"))


	functions:

	a. multi_settings() = overrides the "container" and the "max_selected" configuration 

	b. multi_compiler() = pass an array of users (see note above) in this function 

	c. multi_search() = optional; use this to an input box so that the program will filter out the names of the user
	
	d. multi_get_selected() = retrieves all fb users you selected and gets their fb ids

	*/
		
	(function($){
		var multiSelector = {

			config : {
				container    : $('#friendlist'),
				max_selected : 0
			},

			init: function(config){

				$.extend(this.config, config);

				var $mf	= this;
					$container = $mf.config.container;


				$('<span></span>', {
					text 	: 'Loading Friends..',
					style 	: 'font-style:12px'		
				})
					.appendTo($container);
			},

			compile_data : function(a){

					var $mf				= this;
						$container 		= $mf.config.container,
						$max_selected	= $mf.config.max_selected;

					$container.empty();
			   
				  	for(i in a)
					{
						var uid = a[i].id,
							name = a[i].name;

						$('<div></div>', {
							class 	: 'friends',
							id 		: uid,
							html    : '<img src="https://graph.facebook.com/' + uid + '/picture" width="30" height="30">&nbsp;<span class="friend_name">' + name + '</span>'
						}).appendTo($container);

					}
					
					//trigger function for selecting a friend
					 $("div.friends").click(function ()
					 {
						 //check if number of friends selected is less than the max selected or if the clicked div has class selected 	
						if (($('div.friends.selected').length < $max_selected) || ($(this).hasClass('selected')) || ($max_selected == 0)) {
							$(this).toggleClass('selected');
						}
						
						//console.log(multiSelector.options.max_selected());

						var num_arr = $.map($('.friends.selected'), function(n, i){
						  return n.id;
						});
						
						//update num selected
						$('#num_selected').html(num_arr.length);
					 });
				},

			get_selected_friends : function()
			{
				$arr = $.map($('.friends.selected'), function(n, i){
				  return n.id;
				});

				return $arr;
			},

			search_friends : function(input_id)
			{
				var $mf = this,
					$container = $mf.config.container;

				 $(input_id).keyup(function() {
			
					var search_str = input_id.val().toLowerCase().replace(/\b[a-z]/g, function(letter) {return letter.toUpperCase();});

					if(search_str.length > 0)
					{
						$('.friends').hide();
						
						 $container.find(':contains("'+search_str+'")').css('display','inline');
					}
					else{$('.friends').show();}

				 });
			}
		};

		$.fn.multi_settings = function(config){

			var $cont 	= this,
				$multi 	= Object.create(multiSelector);

			$multi.init({
				container : $cont,
				max_selected : config.max_selected
			});

		};

		$.fn.multi_compiler = function(a) {

			Object.create(multiSelector).compile_data(a);
		};

		$.fn.multi_search = function(){

			Object.create(multiSelector).search_friends(this);

		};

		$.fn.multi_get_selected = function(a) {

			return Object.create(multiSelector).get_selected_friends();
		};
	})(jQuery);
