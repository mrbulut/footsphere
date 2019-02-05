<?php
class SettingsWooUserRolePrices
{
    const GENERAL_SETTINGS_CSS_CLASS = 'general-settings';
    const HIDING_SETTINGS_CSS_CLASS = 'hiding-settings';
    
    private $_languageDomain = '';

    public function __construct($languageDomain)
    {
        $this->_languageDomain = $languageDomain;
    } // end __construct

    public function get()
    {
        $settings = array(
            'roles' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'User Roles for Special Pricing'
                ),
                'type' => 'multicheck',
                'default' => array(),
                'fieldsetKey' => 'general',
                'classes' => 'festi-user-role-prices-top-border '.
                    static::GENERAL_SETTINGS_CSS_CLASS,
                'deleteButton' => true,
                'hint' => StringManagerWooUserRolePrices::getWord(
                    'Select user roles which should be active on '.
                    'product page for special prices'
                ),
            ),
            'discountOrMakeUp' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'Discount or Markup for Products'
                ),
                'type' => 'input_select',
                'values' => array(
                    'discount' => StringManagerWooUserRolePrices::getWord(
                        'discount'
                    ),
                    'markup' => StringManagerWooUserRolePrices::getWord(
                        'markup'
                    )
                ),
                'default' => 'discount',
                'fieldsetKey' => 'general',
                'classes' => 'festi-user-role-prices-top-border '.
                    static::GENERAL_SETTINGS_CSS_CLASS,
                'hint' => StringManagerWooUserRolePrices::getWord(
                    'Provide discount or markups in fixed or percentage terms 
                    for all products on shop'
                ),
            ),
            'bothRegularSalePrice' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'Use for both Regular price and Sale price'
                ),
                'type' => 'input_checkbox',
                'fieldsetKey' => 'general',
                'classes' => static::GENERAL_SETTINGS_CSS_CLASS,
                'lable' => '',
            ),
            
            'discountByRoles' => array(
                'caption' => '',
                'type' => 'multidiscount',
                'default' => array(),
                'fieldsetKey' => 'general',
                'deleteButton' => false,
                'classes' => static::GENERAL_SETTINGS_CSS_CLASS
            ),
            'showCustomerSavings' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'Display Price Savings on'
                ),
                'hint' => StringManagerWooUserRolePrices::getWord(
                    'Display to customer regular price, the user role price '.
                    'with label &quot;Your Price&quot;, and the percent saved '.
                    'with label &quot;Savings&quot;'
                ),
                'type' => 'multi_select',
                'values' => array(
                    'product' => StringManagerWooUserRolePrices::getWord(
                        'Product Page'
                    ),
                    'archive' => StringManagerWooUserRolePrices::getWord(
                        'Products Archive Page (for Simple product)'
                    ),
                    'cartTotal' => StringManagerWooUserRolePrices::getWord(
                        'Cart Page (for Order Total)'
                    ),
                ),
                'default' => array(),
                'fieldsetKey' => 'general',
                'classes' => 'festi-user-role-prices-top-border '.
                    static::GENERAL_SETTINGS_CSS_CLASS
            ),
            'customerSavingsLableColor' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'Color for Savings Labels'
                ),
                'type'    => 'color_picker',
                'fieldsetKey' => 'general',
                'default' => '#ff0000',
                'classes' => static::GENERAL_SETTINGS_CSS_CLASS,
                'eventClasses' => 'showCustomerSavings',
                'hint' => StringManagerWooUserRolePrices::getWord(
                    'Select color for text labels about customer savings '.
                    'Regular Price, Your Price, Savings'
                )
            ),
            'guestUserStatus' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'Custom Text for Guest User'
                ),
                'type' => 'input_checkbox',
                'classes' => 'festi-user-role-prices-top-border '.
                    static::GENERAL_SETTINGS_CSS_CLASS,
                'lable' => StringManagerWooUserRolePrices::getWord(
                    'Enable Custom Text for Guest User'
                ),
                'fieldsetKey' => 'general',
            ),
            'guestUserTextArea' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'Custom User Text'
                ),
                'type' => 'textarea',
                'classes' => 'custom-guest-user-text '.
                    static::GENERAL_SETTINGS_CSS_CLASS,
                'hint' => StringManagerWooUserRolePrices::getWord(
                    'Provide written text which '.
                    'will be displayed under of the price'
                ),
                'fieldsetKey' => 'general',
            ),
            'rulesForNonRegistered' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    '<h2>Rules for Non-Registered Users</h2>'
                ),
                'type' => 'text',
                'fieldsetKey' => 'hide',
                'classes' => 'festi-h2 '.static::HIDING_SETTINGS_CSS_CLASS,
                'text' => ''
            ),
            'hideAddToCartButton' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'Hide the &quot;Add to Cart&quot; Button'
                ),
                'type' => 'input_checkbox',
                'fieldsetKey' => 'hide',
                'classes' => 'festi-case-hide-add-to-cart-button '.
                    static::HIDING_SETTINGS_CSS_CLASS,
                'lable' => StringManagerWooUserRolePrices::getWord(
                    'Enable hidden the &quot;Add to Cart&quot; button'
                ),
            ),
            'textForNonRegisteredUsers' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'Text Instead of '.
                    '&quot;Add to Cart&quot; button'
                ),
                'type' => 'textarea',
                'fieldsetKey' => 'hide',
                'classes' =>
                    'festi-case-text-instead-button-for-non-registered-users '.
                    static::HIDING_SETTINGS_CSS_CLASS,
                'hint' => StringManagerWooUserRolePrices::getWord(
                    'Provide written text which '.
                    'will be displayed on instead of &quot;Add to Cart&quot; 
                    button'
                )
            ),
            'onlyRegisteredUsers' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'Hide the Prices',
                    $this->_languageDomain
                ),
                'type' => 'input_checkbox',
                'fieldsetKey' => 'hide',
                'classes' => 'festi-user-role-prices-top-border '.
                    'festi-case-only-registered-users  festi-padding '.
                    static::HIDING_SETTINGS_CSS_CLASS,
                'lable' => StringManagerWooUserRolePrices::getWord(
                    'Enable hidden prices for all products'
                ),
            ),
            'textForUnregisterUsers' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'Text Instead of Price'
                ),
                'type' => 'textarea',
                'default' => StringManagerWooUserRolePrices::getWord(
                    'Please login or register to see price'
                ),
                'fieldsetKey' => 'hide',
                'classes' => 'festi-case-text-for-unregistered-users '.
                    static::HIDING_SETTINGS_CSS_CLASS,
                'hint' => StringManagerWooUserRolePrices::getWord(
                    'Provide written text which '.
                    'will be displayed on instead of the price'
                ),
            ),
            'rulesForRegistered' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    '<h2>Rules for Registered Users</h2>'
                ),
                'type' => 'text',
                'fieldsetKey' => 'hide',
                'classes' => 'festi-border-top-hiding-rules-tab festi-h2 '.
                    static::HIDING_SETTINGS_CSS_CLASS,
                'text' => ''
            ),
            'hideAddToCartButtonForUserRoles' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'Hide the &quot;Add to Cart&quot; Button'
                ),
                'type' => 'multicheck',
                'default' => array(),
                'fieldsetKey' => 'hide',
                'deleteButton' => false,
                'classes' => static::HIDING_SETTINGS_CSS_CLASS,
                'hint' => StringManagerWooUserRolePrices::getWord(
                    'Enable hidden the &quot;Add to Cart&quot;
                     button from certain user roles'
                ),
            ),
            'hidePriceForUserRoles' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'Hide the Prices'
                ),
                'type' => 'multicheck',
                'default' => array(),
                'fieldsetKey' => 'hide',
                'deleteButton' => false,
                'classes' => 'festi-user-role-prices-top-border '.
                    'festi-case-hide-price-for-user-roles '.
                    static::HIDING_SETTINGS_CSS_CLASS,
                'hint' => StringManagerWooUserRolePrices::getWord(
                    'Enable hidden prices from certain user roles'
                ),
            ),
            'textForRegisterUsers' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'Text with Hidden Price'
                ),
                'type' => 'textarea',
                'default' => StringManagerWooUserRolePrices::getWord(
                    'Price for your role is hidden'
                ),
                'fieldsetKey' => 'hide',
                'classes' => 'festi-case-text-for-registered-users '.
                    'festi-hint-upper '. static::HIDING_SETTINGS_CSS_CLASS,
                'hint' => StringManagerWooUserRolePrices::getWord(
                    'Provide written text with certain '.
                    'roles which will be shown instead of the product price'
                )
            ),
            'hideEmptyPrice' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'Hide Empty Price'
                ),
                'type' => 'multicheck',
                'default' => array(),
                'deleteButton' => false,
                'fieldsetKey' => 'hide',
                'classes' =>
                    'festi-case-hide-empty-price '.
                    'festi-user-role-prices-top-border '.
                    static::HIDING_SETTINGS_CSS_CLASS,
                'hint' => StringManagerWooUserRolePrices::getWord(
                    'Enable hidden empty price from certain user roles'
                ),
            ),
            'textForEmptyPrice' => array(
                'caption' => StringManagerWooUserRolePrices::getWord(
                    'Text Instead of Empty Price'
                ),
                'type' => 'textarea',
                'fieldsetKey' => 'hide',
                'classes' =>
                    'festi-case-text-instead-empty-price '.
                    static::HIDING_SETTINGS_CSS_CLASS,
                'hint' => StringManagerWooUserRolePrices::getWord(
                    'Provide written text which '.
                    'will be displayed on instead of empty price'
                )
            )
        );

        return $settings;
    } // end get
}