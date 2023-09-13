/**
 * @Filename: search-front.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import NhValidator    from './helpers/Validator';
import NhUiCtrl       from './inc/UiCtrl';

class NhSearchFront
{
    constructor()
    {
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            search: {
                form: $(`.${KEY}_header_search`),
                parent: $(`.${KEY}_header_search`).parent(),
                icon: $(`.${KEY}-header-search-icon`),
                input: $(`#${KEY}_s`),
            },
        };

        this.initialization();
    }

    initialization()
    {
        this.showSearch();
    }

    showSearch()
    {
        let that           = this,
            $search = this.$el.search;


        $search.icon.on('click', $search.parent, function (e) {
            e.preventDefault();
            let $this    = $(e.currentTarget);

            $search.input.animate({ opacity: 1, width: '250px' }, 250);
            $search.input.focus();
            $search.input.val('');

        });

        $(document).on('click', function (e) {
            let $this = $(e.target);
                if ($('#ninja_s').css('opacity') === '1' && !$this.hasClass('ninjaheader-search-icon') && !$this.parent().hasClass('ninjas')) {
                $search.input.animate({ opacity: 0, width: '0' }, 250)
            }
        })
    }
}

new NhSearchFront();