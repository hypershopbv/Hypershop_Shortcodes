# Hypershop_Shortcodes

## Goal
- This module is created to add shortcodes to CMS pages & blocks and convert those into HTML wraps.

## Installation / Setup
- Install the module using the command `composer require hypershop/module-shortcodes`
- After installing, run a bin/magento setup:upgrade to add it to the Magento module list.

## Usage / Settings
Initially the only shortcode to this module is:
```
[wrap]
Your content here
[/wrap]
```

This will be converted into:

```
<div class="wrap">
Your content here
</div>
```

You can extend the shortcode list within your theme or through a custom module by extending it like this:

```
<referenceBlock name="shortcodes">
    <arguments>
        <argument name="list" xsi:type="array">
            <item name="second-shortcode" xsi:type="array">
                <item name="shortcode" xsi:type="string">second-shortcode</item>
                <item name="class" xsi:type="string">second-shortcode-class</item>
            </item>
            <item name="third-shortcode" xsi:type="array">
                <item name="shortcode" xsi:type="string">third-shortcode</item>
                <item name="class" xsi:type="string">third-shortcode-class</item>
            </item>
        </argument>
    </arguments>
</referenceBlock>
```

## Common issues
- None known so far.
