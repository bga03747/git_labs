	/*
	Jquery Multi-friend selector beta 1.2

	*/
	
	//check browser object utility 
	if( typeof Object.create !== 'function' ){
		Object.create = function( obj ){
			function F(){};
			F.prototype = obj;
			return new F();
		}
	} /**/

	(function($, window, document, undefined){

		var multiSelector = {

			init : function( options, elem ){
				var self = this;

				self.elem = elem;
				self.$elem = $( elem );

				if( typeof options === "string" ){

					self.data_url = options;

				}else{

					//object was passed
					self.data_url = options.data_url;
					self.options = $.extend( {}, $.fn.fb_friend_selector.options, options );

				}

				self.cycle();
			},

			cycle : function (){
				var self = this;

				self.fetch().done(function( results ){
					self.compile(results);	
				});
			},

			fetch : function(){
				return $.ajax({
				   type: 'POST',
				   url: this.data_url,
				   data: '',
				   cache: false,
				   dataType:'json'
				});
			},

			compile : function(a){

				var self = this,
					container = self.$elem;
					max_sel = self.options.max_selected;

				container.empty();
		   
			  	for(i in a)
				{
					var uid = a[i].id,
						name = a[i].name;

					$('<div></div>', {
						class 	: 'friends',
						id 		: uid,
						html    : '<img src="https://graph.facebook.com/' + uid + '/picture" width="30" height="30">&nbsp;<span class="friend_name">' + name + '</span>'
					}).appendTo(container);

				}

				//trigger function for selecting a friend
				 $("div.friends").click(function ()
				 {
					 //check if number of friends selected is less than the max selected or if the clicked div has class selected 	
					if (($('div.friends.selected').length < max_sel) || ($(this).hasClass('selected')) || (max_sel == 0)) {
						$(this).toggleClass('selected');
					}
					
				 });

				 //check if the search function is activated
				 if(self.options.search == true)
				 {
				 	self.search_friends();
				 }
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
				var self = this;

				var search_id = $("#" + self.options.search_id);

				 search_id.keyup(function() {

					var search_str = search_id.val().toLowerCase().replace(/\b[a-z]/g, function(letter) {return letter.toUpperCase();});

					if(search_str.length > 0)
					{
						$('.friends').hide();

						 self.elem.find(':contains("'+search_str+'")').css('display','inline');
					}
					else{$('.friends').show();}

				 });
			}
		};

		$.fn.fb_friend_selector = function( options ){
			
			var self = this;

			$('<span></span>', {
					text 	: 'Loading Friends..',
					style 	: 'font-style:12px'		
				}).appendTo(self);

			return self.each(function(){
				
				var multi_selector = Object.create(multiSelector);

				multi_selector.init( options, self );
			});

		};

		$.fn.fb_friend_selector.options = {
			max_selected : 0,
			search       : false,
			search_id    : 'search_friend'
		};

		$.fn.multi_get_selected = function() {

			return Object.create(multiSelector).get_selected_friends();
		};

		
	})(jQuery, window, document);
