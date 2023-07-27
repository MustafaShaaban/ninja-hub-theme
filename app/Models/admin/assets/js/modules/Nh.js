/**
 * @Filename: Nh.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 5/13/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

class Nh
{
    constructor()
    {
        this.addSerializeObject();
    }

    addSerializeObject()
    {
        $.fn.serializeObject = function () {
            let a = {},
                b = function (b, c) {
                    let d = a[c.name];
                    'undefined' !== typeof d && d !== null ? $.isArray(d) ? d.push(c.value) : a[c.name] = [
                        d,
                        c.value,
                    ] : a[c.name] = c.value;
                };
            return $.each(this.serializeArray(), b), a;
        };
    }

}

export default Nh;