export class List {
    constructor() {
        this.initRowAddedEventListener();
        this.initArchiveFilterEventListener();
        this.content_url = $('#datatable').attr('data-content-url');
    }

    initRowAddedEventListener() {
        let that = this;
        addEventListener('uccello.list.row_added', function(event) {
            if (event.detail.record.archived_at !== null) {
                let unarchive_label = $('a.archive-btn', event.detail.element).attr('data-unarchive-label');
                $('a.archive-btn', event.detail.element).attr('data-tooltip', unarchive_label);
                $('a.archive-btn i', event.detail.element).text('unarchive');
            }
            $('.archive-btn', event.detail.element).on('click', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                let archive_url = $(this).attr('href');
                $.get(archive_url).then(() => {
                    console.log($(this).parents('table:first').attr('id'));
                    that.dispatchCustomEvent($(this).parents('table:first').attr('id'));
                });

            });
        });
    }

    initArchiveFilterEventListener() {
        let that = this;
        $('[data-archive-filter]').on('click', function(e) {
            $('#archive-dropdown').find('li').each(function (){
                $(this).removeClass('active');
            });
            $(this).parent().addClass('active');
            let filter = $(this).data('archive-filter');
            let table = $(this).parents('ul:first').data('table');

            // Add filter to content URL
            let $datatable = $('#' + table);
            $datatable.attr('data-content-url', that.content_url + '/archive?filter=' + filter);
            that.dispatchCustomEvent(table);
            
        });
    }
    
    dispatchCustomEvent(table_id) {
        // Refresh datatable
        let event = new CustomEvent('uccello.list.refresh', {detail: table_id});
        dispatchEvent(event);
    }

}
