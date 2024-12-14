<!DOCTYPE html>
<html>

<head>
    <title>Drag and Drop Builder</title>
    <link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet">
</head>

<body>
    <div id="gjs"></div>
    <script src="https://unpkg.com/grapesjs"></script>
    <script src="https://unpkg.com/grapesjs-blocks-basic"></script>
    <script src="https://unpkg.com/grapesjs-plugin-forms"></script>
    <script src="https://unpkg.com/grapesjs-navbar"></script>
    <script src="https://unpkg.com/grapesjs-plugin-export"></script>
    <script src="https://unpkg.com/grapesjs-tooltip"></script>
    <script type="text/javascript">
        var editor = grapesjs.init({
            container: '#gjs',
            plugins: [
                'gjs-blocks-basic',
                'gjs-plugin-forms',
                'gjs-navbar',
                'gjs-plugin-export',
                'gjs-tooltip',
            ],
            pluginsOpts: {
                'gjs-blocks-basic': {},
                'gjs-plugin-forms': {},
                'gjs-navbar': {},
                'gjs-plugin-export': {
                    addExportBtn: true,
                    btnLabel: 'Export',
                    filenamePfx: 'my-template'
                },
                'gjs-tooltip': {}
            },
            height: '100%',
            fromElement: true,
            storageManager: {
                autoload: 0
            },
            styleManager: {
                sectors: [{
                    name: 'General',
                    open: false,
                    buildProps: ['float', 'display', 'position', 'top', 'right', 'left', 'bottom']
                }, {
                    name: 'Flex',
                    open: false,
                    buildProps: ['flex-direction', 'flex-wrap', 'justify-content', 'align-items',
                        'align-content', 'order', 'flex-basis', 'flex-grow', 'flex-shrink', 'align-self'
                    ]
                }, {
                    name: 'Dimension',
                    open: false,
                    buildProps: ['width', 'height', 'max-width', 'min-height', 'margin', 'padding'],
                }, {
                    name: 'Typography',
                    open: false,
                    buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color',
                        'line-height', 'text-shadow'
                    ],
                }, {
                    name: 'Decorations',
                    open: false,
                    buildProps: ['border-radius-c', 'background-color', 'border-radius', 'border',
                        'box-shadow', 'background'
                    ],
                }, {
                    name: 'Extra',
                    open: false,
                    buildProps: ['transition', 'perspective', 'transform'],
                }]
            },
        });

        // Adding blocks for forms and other components
        editor.BlockManager.add('formBlock', {
            label: 'Form Block',
            content: {
                tagName: 'form',
                draggable: true,
                attributes: {
                    'method': 'post'
                },
                components: [{
                    tagName: 'input',
                    type: 'text',
                    attributes: {
                        'placeholder': 'Enter text here'
                    }
                }, {
                    tagName: 'input',
                    type: 'email',
                    attributes: {
                        'placeholder': 'Enter email here'
                    }
                }, {
                    tagName: 'input',
                    type: 'submit',
                    attributes: {
                        'value': 'Submit'
                    }
                }]
            }
        });

        // Example of adding a simple block
        editor.BlockManager.add('testBlock', {
            label: 'Simple Block',
            attributes: {
                class: 'gjs-fonts gjs-f-b1'
            },
            content: '<div style="padding:20px; text-align:center;">Simple block</div>'
        });
    </script>
</body>

</html>
