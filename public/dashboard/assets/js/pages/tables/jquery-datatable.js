$(function () {
    $('.js-basic-example').DataTable({
        /*dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],*/
        'ordering'    : false,
        language: {
            processing:     "جارٍ التحميل...",
            search:         "بحث",
            lengthMenu:    "أظهر _MENU_ مدخلات",
            info:           "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
            infoEmpty:      "يعرض 0 إلى 0 من أصل 0 سجل",
            infoFiltered:   "(منتقاة من مجموع _MAX_ مُدخل)",
            infoPostFix:    "",
            loadingRecords: "جارٍ التحميل...",
            zeroRecords:    "لم يعثر على أية سجلات",
            emptyTable:     "عفوا لا توجد بيانات",
            paginate: {
                first:      "الأول",
                previous:   "السابق",
                next:       "التالي",
                last:       "الأخير"
            },
            aria: {
                sortAscending:  ": تفعيل لترتيب العمود تصاعدياً",
                sortDescending: ": تفعيل لترتيب العمود تنازلياً"
            }
        }
    });

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],

        'paging'      : true,
        'lengthChange': true,
    });
});
