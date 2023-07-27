/**
 * @Filename: opportunity-front.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import NhValidator    from './helpers/Validator';
import NhUiCtrl        from './inc/UiCtrl';
import NhOpportunity from './modules/Opportunity';

class NhOpportunityFront extends NhOpportunity
{
    constructor()
    {
        super();
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            opportunity: {
                form: $(`#${KEY}_create_opportunity_form`),
                parent: $(`#${KEY}_create_opportunity_form`).parent(),
            },
        };

        this.initialization();
    }

    initialization()
    {
    }
}

new NhOpportunityFront();