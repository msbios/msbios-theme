<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
return [
    'identifier' => 'examples',
    'title' => 'Default Examples Theme',
    'description' => 'Default Examples Theme Descritpion',
    // Doctype with which to seed the Doctype helper
    // 'doctype' => $doctypeHelperConstantString, // e.g. HTML5, XHTML1
    // TemplateMapResolver configuration
    // template/path pairs
    'template_map' => [
        // key => value
    ],
    // TemplatePathStack configuration
    // module/view script path pairs
    'template_path_stack' => [
        __DIR__ . '//view',
    ],
    // Default suffix to use when resolving template scripts, if none, 'phtml' is used
    // 'default_template_suffix' => $templateSuffix, // e.g. 'php'
    // Controller namespace to template map
    // or whitelisting for controller FQCN to template mapping
    'controller_map' => [
    ],
    // Layout template name
    // 'layout' => $layoutTemplateName, // e.g. 'layout/layout'
    // ExceptionStrategy configuration
    // 'display_exceptions' => $bool, // display exceptions in template
    // 'exception_template' => $stringTemplateName, // e.g. 'error'
    // RouteNotFoundStrategy configuration
    // 'display_not_found_reason' => $bool, // display 404 reason in template
    // 'not_found_template' => $stringTemplateName, // e.g. '404'
    // Additional strategies to attach
    // These should be class names or service names of View strategy classes
    // that act as ListenerAggregates. They will be attached at priority 100,
    // in the order registered.
    'translation_file_patterns' => [
        [
            'type' => 'gettext',
            'base_dir' => __DIR__ . '/language/',
            'pattern' => '%s.mo',
        ],
    ],
];