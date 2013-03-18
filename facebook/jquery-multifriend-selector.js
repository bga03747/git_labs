	$(document).ready(function()
	{
		var $container = $('#friendlist'), 

			max_selected = <?php echo $nom_arr['max_sel'];?>,

			multiSelector = {
			
			init: function(){
					$('<span></span>', {
						text 	: 'Loading Friends..',
						style 	: 'font-style:12px'		
					})
						.appendTo($container);	
				},

			compile_data : function(a){
					//alert(b);

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
						if (($('div.friends.selected').length < max_selected) || ($(this).hasClass('selected'))) {
							$(this).toggleClass('selected');
						}
						
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

			search_friends : function()
			{
				//input id
				 $('#search_friend').keyup(function() {
			
					var search_str = $(this).val().toLowerCase().replace(/\b[a-z]/g, function(letter) {return letter.toUpperCase();});
					
					if(search_str.length > 0)
					{
						$('.friends').hide();
						
						 $container.find(':contains("'+search_str+'")').css('display','inline');
					}
					else{$('.friends').show();}

				 });
			}
		};
		
		multiSelector.init();