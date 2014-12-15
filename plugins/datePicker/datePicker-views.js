 $(function() {

                $("#datepicker-add-options").datepicker({
                    dateFormat: "yyyy.m.d",
                    weekStart: 1
                });

                // Methods
                var $datepicker = $("#datepicker-methods"),
                    $show = $("#datepicker-show"),
                    $hide = $("#datepicker-hide"),
                    $enable = $("#datepicker-enable"),
                    $disable = $("#datepicker-disable"),
                    $update = $("#datepicker-update"),
                    datepicker;

                // Initialize
                $datepicker.datepicker();

                // Get the instance
                datepicker = $datepicker.data("datepicker");

                // Show
                $show.click(function() {
                    $datepicker.datepicker("show");
                });

                // Hide
                $hide.click(function() {
                    datepicker.hide();
                });

                // Enable
                $enable.click(function() {
                    $datepicker.datepicker("enable");
                });

                // Disable
                $disable.click(function() {
                    datepicker.disable();
                });

                // Update
                $update.click(function() {
                    $datepicker.val("02/25/2020").datepicker("update").datepicker("show");
                });

                $(".datepicker").datepicker();

                $("#datepicker-view-start").datepicker({
                    autoClose: true,
                    viewStart: 2
                });

                var now = Date.now();

                $("#datepicker-disable-past").datepicker({
                    isDisabled: function(date) {
                        return date.valueOf() < now ? true : false;
                    }
                });

                $("#datepicker-disable-wednesday").datepicker({
                    isDisabled: function(date) {
                        return date.getDay() === 3 ? true : false;
                    }
                });

                var minDate = (new Date(2020, 1, 15)).getTime(),
                    maxDate = (new Date(2020, 2, 25)).getTime();

                // Set date range
                $("#datepicker-date-range").datepicker({
                    isDisabled: function(date) {
                        date = date.getTime();

                        return (date < minDate || date > maxDate) ? true : false;
                    }
                });
            });