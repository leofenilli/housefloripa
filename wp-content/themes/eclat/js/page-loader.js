/* Copyright (C) Elartica Team, http://www.gnu.org/licenses/gpl.html GNU/GPL */

jQuery(function($) {
    ( function( window ) {

        'use strict';

        function PathLoader( el ) {
            this.el = el;
            // clear stroke
            this.el.style.strokeDasharray = this.el.style.strokeDashoffset = this.el.getTotalLength();
        }

        PathLoader.prototype._draw = function( val ) {
            this.el.style.strokeDashoffset = this.el.getTotalLength() * ( 1 - val );
        };

        PathLoader.prototype.setProgress = function( val, callback ) {
            this._draw(val);
            if( callback && typeof callback === 'function' ) {
                // give it a time (ideally the same like the transition time) so that the last progress increment animation is still visible.
                setTimeout( callback, 200 );
            }
        };

        PathLoader.prototype.setProgressFn = function( fn ) {
            if( typeof fn === 'function' ) { fn( this ); }
        };

        // add to global namespace
        window.PathLoader = PathLoader;

    })( window );

    var support = { animations : Modernizr.cssanimations },
        container = document.body,
        header = document.getElementById( 'loader-page' ),
        loader = new PathLoader( document.getElementById( 'loader-circle' ) ),
        animEndEventNames = { 'WebkitAnimation' : 'webkitAnimationEnd', 'OAnimation' : 'oAnimationEnd', 'msAnimation' : 'MSAnimationEnd', 'animation' : 'animationend' },
    // animation end event name
        animEndEventName = animEndEventNames[ Modernizr.prefixed( 'animation' ) ];

    function init() {
        var onEndInitialAnimation = function() {
            if( support.animations ) {
                this.removeEventListener( animEndEventName, onEndInitialAnimation );
            }

            startLoading();
        };

        // disable scrolling
        window.addEventListener( 'scroll', noscroll );

        // initial animation
        //classie.add( container, 'loading' );
        $('body').addClass('loading');

        if( support.animations ) {
            container.addEventListener( animEndEventName, onEndInitialAnimation );
        }
        else {
            onEndInitialAnimation();
        }
    }

    function startLoading() {
        // simulate loading something..
        var simulationFn = function(instance) {
            var progress = 0,
                interval = setInterval( function() {
                    progress = Math.min( progress + Math.random() * 0.1, 1 );

                    instance.setProgress( progress );

                    $('.loader-logo div').html(Math.round(progress*100));

                    // reached the end
                    if( progress === 1 ) {

                        $('.loader-logo div').html(Math.round(progress*100));

                        $('body').removeClass('loading').addClass('loaded');
                        clearInterval( interval );

                        var onEndHeaderAnimation = function(ev) {
                            if( support.animations ) {
                                if( ev.target !== header ) return;
                                this.removeEventListener( animEndEventName, onEndHeaderAnimation );
                            }

                            window.removeEventListener( 'scroll', noscroll );
                        };

                        if( support.animations ) {
                            header.addEventListener( animEndEventName, onEndHeaderAnimation );
                        }
                        else {
                            onEndHeaderAnimation();
                        }
                    }
                }, 80 );
        };

        loader.setProgressFn( simulationFn );
    }

    function noscroll() {
        window.scrollTo( 0, 0 );
    }

    init();
});