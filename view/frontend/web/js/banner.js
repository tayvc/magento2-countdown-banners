define([
    'jquery',
    'jquery-ui-modules/widget'
    ],
    function($) {
        $.widget('mage.countdownBanner', {
            options: {
                timerEnd: new Date().toUTCString(),
                currentTime: new Date().toUTCString(),
            },

            _create: function() {
                setInterval(this.getTimer.bind(this),1000);
            },
            
            getTimer: function() {
                var t = this.getTimeRemaining();
                this.element.find('.countdown-days').html(t.days);
                this.element.find('.countdown-hours').html(t.hours);
                this.element.find('.countdown-minutes').html(t.minutes);
                this.element.find('.countdown-seconds').html(t.seconds);
            },

            getTimeRemaining: function() {
                var total = new Date(this.options.timerEnd) - Date.now();
                var time = {
                    'total': 00,
                    'days': 00,
                    'hours': 00,
                    'minutes': 00,
                    'seconds': 00
                };
                
                if (Math.sign(total) > 0) {
                    time.seconds = this._zeroPadding(Math.floor( (total/1000) % 60 ));
                    time.minutes = this._zeroPadding(Math.floor( (total/1000/60) % 60 ));
                    time.hours = this._zeroPadding(Math.floor( (total/(1000*60*60)) % 24 ));
                    time.days = this._zeroPadding(Math.floor( total/(1000*60*60*24) ));
                } 

                return time;
            },

            _zeroPadding: function(digit) {
                return digit < 10 ? '0' + digit : digit;
            }

        });
        return $.mage.countdownBanner;
    }
);
