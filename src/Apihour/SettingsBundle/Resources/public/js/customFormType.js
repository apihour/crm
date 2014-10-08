var CustomFormType = function() {
    "use strict";
    var type = 'text';
    var defaultValueContainer;
    var choiceContainer;
    var baseFormElementParams = {
        id: null,
        name: null,
        required: true,
        placeholder: '',
        class: 'form-control'
    };

    var setDefaultValueContainer = function(container) {
        defaultValueContainer = container;
    };
    var setBaseFormElementParams = function(params) {
        baseFormElementParams = $.extend(
            baseFormElementParams,
            params
        );
    };

    var handleChangeableType = function($el) {
        if ($el !== undefined) {
            if ($el.val() !== 'choice') {
                choiceContainer.hide();
            }

            $el.change(function () {
                if ($(this).val() === 'choice') {
                    choiceContainer.show();
                } else {
                    choiceContainer.hide();
                }
            });
        }
    };

    var changeDefaultValueContainer = function() {
        if (type === 'text') {
            changeFormToText();
        } else if (type === 'textarea') {
            changeFormToTextarea();
        } else if (type === 'choice') {
            changeFormToChoice();
        }
    };

    var decorateFormElement = function ($el, attr) {
        var opt = {};
        $.extend(opt, baseFormElementParams, attr);
        $.each(opt, function (k, v) {
            $el.attr(k, v);
        });

        return $el;
    };

    var changeFormToChoice = function () {
        if (choiceContainer.attr('class') === undefined) {
            choiceContainer = $('<div>').attr('class', 'choice-container');
        }

        var input     = decorateChoiceInput();
        var add       = decorateChoiceAddButton(choiceContainer);

        choiceContainer.append(input);
        choiceContainer.append(add);

        defaultValueContainer.html(choiceContainer);
    };

    var decorateChoiceAddButton = function ($container) {
        return $('<div>').attr('class', 'form-group').append(
            $('<div>').attr('class', 'col-md-12').append(
                $('<a>').attr('class', 'btn btn-success').text('asd')
                    .click(function () {
                        $container.prepend(decorateChoiceInput());
                        return false;
                    })
            )
        );
    };

    var decorateChoiceInput = function () {
        var name = baseFormElementParams.name.concat('[]');

        return $('<div>').attr('class', 'form-group').append(
            $('<div>').attr('class', 'col-md-12').append(
                $('<span>').attr('class', 'input-icon input-icon-right')
                    .append(decorateFormElement($('<input>'), {type: 'text', name: name}))
                    .append(
                    $('<i>').attr('class', 'fa fa-times').click(function () {
                        $(this).parentsUntil('.form-group').parent().remove();
                    })
                )
            )
        );
    };

    return {
        //main function to initiate template pages
        init : function(params) {
            var options = $.extend({
                handleChangeableType: null,
                defaultValueContainer: null,
                type: 'text',
                baseFormElementParams: {},
                choiceContainer: null
            }, params);

            choiceContainer = options.choiceContainer;
            setBaseFormElementParams(options.baseFormElementParams);
            setDefaultValueContainer(options.defaultValueContainer);
            handleChangeableType(options.handleChangeableType);
        },
        decorateChoiceInput: function () {
            return decorateChoiceInput();
        },
        getChoiceContainer: function () {
            return choiceContainer;
        },
        decorateChoiceAddButton: function ($container) {
            return decorateChoiceAddButton($container);
        }
    };
}();
