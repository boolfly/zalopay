/**********************************************************************
 * Zalo Pay payment
 *
 * @copyright Copyright © Boolfly. All rights reserved.
 * @author    info@boolfly.com
 */
define([
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ], function (Component, rendererList) {
        'use strict';

        rendererList.push(
            {
                type: 'zalopay',
                component: 'Boolfly_ZaloPay/js/view/payment/method-renderer/zalopay-wallet'
            }
        );

        /**
         * Add view logic here if needed
         */

        return Component.extend({});
    });
