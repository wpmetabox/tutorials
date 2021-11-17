( function( document ) {
	function Countdown( el ) {
		this.el = el;

		this.days = this.el.querySelector( '.countdown-days' );
		this.hours = this.el.querySelector( '.countdown-hours' );
		this.minutes = this.el.querySelector( '.countdown-minutes' );
		this.seconds = this.el.querySelector( '.countdown-seconds' );

		this.countdown = function() {
			var time = new Date( this.el.dataset.end ).getTime();
			var now = new Date().getTime();
			var distance = ( time - now ) / 1000;

			if ( distance < 0 ) {
				this.days.innerHTML = '0';
				this.hours.innerHTML = '0';
				this.minutes.innerHTML = '0';
				this.seconds.innerHTML = '0';
				clearInterval( this.timer );
				return;
			}

			this.days.innerHTML = Math.floor(distance / 86400);
			this.hours.innerHTML = Math.floor((distance % 86400) / 3600);
			this.minutes.innerHTML = Math.floor((distance % 3600) / 60);
			this.seconds.innerHTML = Math.floor(distance % 60);
		};

		this.timer = setInterval( this.countdown.bind( this ), 1000 );
	}

	document.querySelectorAll( '.countdown' ).forEach( function( el ) {
		new Countdown( el );
	} );
} )( document );