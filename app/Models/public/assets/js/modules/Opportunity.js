/**
 * @Filename: Opportunity.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $      from 'jquery';
import UiCtrl from '../inc/UiCtrl';
import Nh     from './Nh';

class NhOpportunity extends Si
{
    constructor()
    {
        super();
        this.ajaxRequests = {};
    }
}

export default NhOpportunity;
