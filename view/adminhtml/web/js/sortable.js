/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'mage/template',
    'mage/backend/validation'
], function ($, template) {
    'use strict';

    $.widget('eriocnemis.sortableField', {

        /**
         * Widget config option
         * @var {object}
         */
        options: {
            isSortable: false,
            isReadOnly: false,
            template: '#row-template'
        },

        /**
         * New item count
         * @var {integer}
         */
        itemCount: 0,

        /**
         * Template object
         * @var {template}
         */
        template: null,

        /**
         * Initialize Widget
         * @returns {void}
         */
        _create: function() {
            this.initTemplate();
            if (this.options.isSortable) {
                this.initSortable();
            }
            this.initButton();
            this.addValidation();
        },

        /**
         * Add validation rule
         * @return {void}
         */
        addValidation: function () {
            $.validator.addMethod(
                'required-label-rows', function (value, element) {
                    var labelFlag = false;
                    $('[data-role=options-container]').find('tr').each(function () {
                        if (!$(this).hasClass('no-display')) {
                            labelFlag = true;
                        }
                    });
                    return labelFlag;
                },
                $.mage.__('Please specify at least one label.')
            );
        },

        /**
         * Init template
         * @return {void}
         */
        initTemplate: function() {
            this.template = template(this.options.template);
        },

        /**
         * Init sortable plugin
         * @return {void}
         */
        initSortable: function() {
            $('[data-role=options-container]').sortable({
                distance: 8,
                tolerance: 'pointer',
                cancel: 'input, button, select',
                axis: 'y',
                update: function() {
                    $('[data-role=options-container] [data-role=order]').each(function(index, element) {
                        $(element).val(index + 1);
                    });
                }
            });
        },

        /**
         * Init buttons
         * @return {void}
         */
        initButton: function() {
            if (!this.options.isReadOnly) {
                this.initDelButton();
                this.initAddButton();
            }
        },

        /**
         * Init add button
         * @return {void}
         */
        initAddButton: function() {
            $('#add_new_option_button').click(function() {
                this.addItem();
            }.bind(this));
        },

        /**
         * Init delete button
         * @return {void}
         */
        initDelButton: function() {
            $('#manage-options-panel').on('click', '.delete-option', function(event) {
                this.removeItem(event, event.target);
            }.bind(this));
        },

        /**
         * Retrieve new item data
         * @returns {object}
         */
        getItemData: function() {
            return {
                'id': 'option_' + this.itemCount,
                'sort_order': this.itemCount + 1
            };
        },

        /**
         * Add new item
         * @return {void}
         */
        addItem: function() {
            this.itemCount++;
            this.render(this.template({data: this.getItemData()}));
        },

        /**
         * Remove selected item
         * @return {void}
         */
        removeItem: function(event) {
            var element = $(event.target).closest('tr');
            if (element.length) {
                element.find('.delete-flag').val(1);
                element.addClass('no-display').addClass('ignore-validate').hide();
            }
        },

        /**
         * Render new item
         * @return {void}
         */
        render: function(element) {
            $('[data-role=options-container]').append(element);
        }
    });

    return $.eriocnemis.sortableField;
});
