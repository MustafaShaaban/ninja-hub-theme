/**
 * @Filename: wizard-front.js
 * @Description:
 * @User: NINJA MASTER - Mustafa Shaaban
 * @Date: 1/4/2023
 */

/* global nhGlobals, KEY */

// import theme 3d party modules
import $ from 'jquery';

// import theme modules
import NhUiCtrl from './inc/UiCtrl';

class NhWizardFront
{
    constructor()
    {
        // Initialize the UiCtrl and $el properties
        this.UiCtrl = new NhUiCtrl();
        this.$el    = this.UiCtrl.selectors = {
            // Define selectors for various forms and elements
            wizard: {
                wizardContainer: $(`.${KEY}-attachment-uploader`),
                stepsBtn: $('.nh-wizard-step'),
                previousStepBtn: $('.nh-wizard-step-previous'),
                nextStepBtn: $('.nh-wizard-step-next'),
                finishStepBtn: $('.nh-wizard-step-finish'),
            },
        };

    }

    init()
    {
        let that    = this,
            $wizard = this.$el.wizard;

        $wizard.stepsBtn.on('click', function (e) {
            e.preventDefault();

            let $this         = $(e.currentTarget),
                steps         = $('.nh-steps').length, // 3
                targetStep    = parseInt($this.attr('data-target')),
                currentStep   = parseInt($this.attr('data-current')),
                isCanContinue = $this.triggerHandler('is:canContinue', [
                    $(`.nh-step-${currentStep}`),
                    targetStep,
                    currentStep,
                ]),
                direction     = '';

            if (targetStep > steps || targetStep <= 0) {
                return;
            }

            if (isCanContinue === false) {
                return;
            }

            if ($this.hasClass('nh-wizard-step-finish')) {
                $this.trigger('on:finish', [
                    $this,
                    $(`.nh-step-${steps}`),
                    steps,
                ]);
            }

            if ($(`.nh-step-${targetStep}`).length > 0) {
                if ($this.hasClass('nh-wizard-step-next')) {

                    $this.trigger('on:next', [
                        $(`.nh-step-${targetStep}`),
                        targetStep,
                        currentStep,
                    ]);

                    // Handle Direction
                    direction = nhGlobals.lang === 'ar' ? 'left' : 'right';


                    // Handle Buttons
                    if (targetStep < steps) {
                        $wizard.nextStepBtn.show();
                        $wizard.previousStepBtn.show();
                        $wizard.finishStepBtn.hide();
                    }

                    if (targetStep === steps) {
                        $wizard.nextStepBtn.hide();
                        $wizard.previousStepBtn.show();
                        $wizard.finishStepBtn.show();
                    }


                    // set new step
                    $wizard.nextStepBtn.attr('data-current', currentStep + 1).attr('data-target', targetStep + 1);
                    $wizard.previousStepBtn.attr('data-current', targetStep).attr('data-target', currentStep);

                    $this.trigger('on:shown', [
                        $(`.nh-step-${targetStep}`),
                        targetStep,
                        currentStep,
                        false,
                    ]);
                }

                if ($this.hasClass('nh-wizard-step-previous')) {
                    $this.trigger('on:previous', [
                        $(`.nh-step-${targetStep}`),
                        targetStep,
                        currentStep,
                        false,
                    ]);

                    direction = nhGlobals.lang === 'ar' ? 'right' : 'left';

                    // Handle Buttons
                    $wizard.finishStepBtn.hide();

                    // is not first screen
                    if (targetStep > 1) {
                        $wizard.nextStepBtn.show();
                        $wizard.previousStepBtn.show();


                    }

                    // first screen
                    if (targetStep === 1) {
                        $wizard.nextStepBtn.show();
                        $wizard.previousStepBtn.hide();
                    }

                    // set new step
                    $wizard.nextStepBtn.attr('data-current', currentStep - 1).attr('data-target', currentStep);
                    $wizard.previousStepBtn.attr('data-current', currentStep - 1).attr('data-target', targetStep - 1);

                    $this.trigger('on:shown', [
                        $(`.nh-step-${targetStep}`),
                        targetStep,
                        currentStep,
                        false,
                    ]);
                }

                if ($this.hasClass('nh-wizard-step-finish')) {
                    $this.trigger('on:finish', [
                        $this,
                        $(`.nh-step-${steps}`),
                        steps,
                    ]);

                    direction = nhGlobals.lang === 'ar' ? 'left' : 'right';

                    $this.trigger('on:shown', [
                        $(`.nh-step-${targetStep}`),
                        targetStep,
                        currentStep,
                        false,
                    ]);
                }

                $('.nh-step-active').removeClass('nh-step-active');
                $(`.nh-step-${targetStep}`).addClass('nh-step-active');


                if (direction === 'right') {
                    if (nhGlobals.lang === 'ar') {
                        $(`.nh-step-${targetStep}`).animate({
                            display: 'block',
                            right: '0',
                        }, 500);
                        $(`.nh-step-${currentStep}`).animate({
                            display: 'none',
                            right: '-=100vw',
                        }, 500);
                    } else {
                        $(`.nh-step-${targetStep}`).animate({
                            display: 'block',
                            left: '0',
                        }, 500);
                        $(`.nh-step-${currentStep}`).animate({
                            display: 'none',
                            left: '-=100vw',
                        }, 500);
                    }
                }

                if (direction === 'left') {
                    if (nhGlobals.lang === 'ar') {
                        $(`.nh-step-${targetStep}`).animate({
                            display: 'block',
                            right: '0',
                        }, 500);
                        $(`.nh-step-${currentStep}`).animate({
                            display: 'none',
                            right: '+=100vw',
                        }, 500);
                    } else {
                        $(`.nh-step-${targetStep}`).animate({
                            display: 'block',
                            left: '0',
                        }, 500);
                        $(`.nh-step-${currentStep}`).animate({
                            display: 'none',
                            left: '+=100vw',
                        }, 500);
                    }
                }
            }


        });

        return this;
    };

    slideTo(step_number)
    {
        let that          = this,
            $wizard       = this.$el.wizard,
            steps         = $('.nh-steps').length, // 3
            targetStep    = parseInt(step_number),
            currentStep   = parseInt($('.nh-steps:visible').attr('data-step')),
            visibleScreen = parseInt($('.nh-steps:visible').attr('data-step')),
            direction     = '';

        if (targetStep > steps || targetStep <= 0) {
            return;
        }


        if ($(`.nh-step-${targetStep}`).length > 0) {

            if (visibleScreen < step_number) {
                $(document).trigger('on:next', [
                    $(`.nh-step-${targetStep}`),
                    targetStep,
                    currentStep,
                    false,
                ]);

                // go right
                direction = nhGlobals.lang === 'ar' ? 'left' : 'right';

                // Handle Buttons
                if (targetStep < steps) {
                    $wizard.nextStepBtn.show();
                    $wizard.previousStepBtn.show();
                    $wizard.finishStepBtn.hide();
                }

                if (targetStep === steps) {
                    $wizard.nextStepBtn.hide();
                    $wizard.previousStepBtn.show();
                    $wizard.finishStepBtn.show();
                }


                // set new step
                $wizard.nextStepBtn.attr('data-current', step_number).attr('data-target', targetStep + 1);
                $wizard.previousStepBtn.attr('data-current', targetStep).attr('data-target', step_number);

                $(document).trigger('on:shown', [
                    $(`.nh-step-${targetStep}`),
                    targetStep,
                    currentStep,
                    false,
                ]);
            }

            if (visibleScreen > step_number) {
                $(document).trigger('on:previous', [
                    $(`.nh-step-${targetStep}`),
                    targetStep,
                    currentStep,
                    false,
                ]);

                // go left
                direction = nhGlobals.lang === 'ar' ? 'right' : 'left';

                // Handle Buttons
                $wizard.finishStepBtn.hide();

                // is not first screen
                if (targetStep > 1) {
                    $wizard.nextStepBtn.show();
                    $wizard.previousStepBtn.show();


                }

                // first screen
                if (targetStep === 1) {
                    $wizard.nextStepBtn.show();
                    $wizard.previousStepBtn.hide();
                }

                // set new step
                $wizard.nextStepBtn.attr('data-current', step_number).attr('data-target', step_number + 1);
                $wizard.previousStepBtn.attr('data-current', step_number).attr('data-target', targetStep - 1);

                $(document).trigger('on:shown', [
                    $(`.nh-step-${targetStep}`),
                    targetStep,
                    currentStep,
                    false,
                ]);
            }

            if (visibleScreen === step_number) {
                $(document).trigger('on:finish', [
                    $wizard.finishStepBtn,
                    $(`.nh-step-${steps}`),
                    steps,
                ]);
                // go right
                direction = nhGlobals.lang === 'ar' ? 'left' : 'right';

                $(document).trigger('on:shown', [
                    $(`.nh-step-${targetStep}`),
                    targetStep,
                    currentStep,
                    false,
                ]);
            }

            $('.nh-step-active').removeClass('nh-step-active');
            $(`.nh-step-${targetStep}`).addClass('nh-step-active');


            if (direction === 'right') {
                if (nhGlobals.lang === 'ar') {
                    $(`.nh-step-${targetStep}`).animate({
                        display: 'block',
                        right: '0',
                    }, 500);
                    $(`.nh-step-${currentStep}`).animate({
                        display: 'none',
                        right: '-=100vw',
                    }, 500);
                } else {
                    $(`.nh-step-${targetStep}`).animate({
                        display: 'block',
                        left: '0',
                    }, 500);
                    $(`.nh-step-${currentStep}`).animate({
                        display: 'none',
                        left: '-=100vw',
                    }, 500);
                }
            }

            if (direction === 'left') {
                if (nhGlobals.lang === 'ar') {
                    $(`.nh-step-${targetStep}`).animate({
                        display: 'block',
                        right: '0',
                    }, 500);
                    $(`.nh-step-${currentStep}`).animate({
                        display: 'none',
                        right: '+=100vw',
                    }, 500);
                } else {
                    $(`.nh-step-${targetStep}`).animate({
                        display: 'block',
                        left: '0',
                    }, 500);
                    $(`.nh-step-${currentStep}`).animate({
                        display: 'none',
                        left: '+=100vw',
                    }, 500);
                }
            }
        }


    }
}

export default NhWizardFront;
