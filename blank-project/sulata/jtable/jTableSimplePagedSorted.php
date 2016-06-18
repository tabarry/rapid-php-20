<html>
    <head>

        <link href="themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
        <link href="scripts/jtable/themes/lightcolor/blue/jtable.css" rel="stylesheet" type="text/css" />

        <script src="scripts/jquery-1.6.4.min.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
        <script src="Scripts/jtable/jquery.jtable.js" type="text/javascript"></script>

    </head>
    <body>
        <div id="PeopleTableContainer" style="width: 600px;"></div>
        <script type="text/javascript">

            $(document).ready(function() {

                //Prepare jTable
                $('#PeopleTableContainer').jtable({
                    title: 'Table of people',
                    paging: true,
                    pageSize: 10,
                    sorting: true,
                    defaultSorting: 'Sr ASC',
                    actions: {
                        listAction: 'PersonActionsPagedSorted.php?action=list',
                        //                        createAction: 'PersonActionsPagedSorted.php?action=create',
                        //                        updateAction: 'PersonActionsPagedSorted.php?action=update',
                        deleteAction: 'PersonActionsPagedSorted.php?action=delete'
                    },
                    fields: {
                        Sr: {
                            title: 'Sr.',
                            width: '5%'
                        },
                        PersonId: {
                            key: true,
                            create: false,
                            edit: false,
                            list: true
                        },
                        Name: {
                            title: 'Author Name',
                            width: '40%'
                        },
                        Age: {
                            title: 'Age',
                            width: '20%'
                        },
                        RecordDate: {
                            title: 'Record date',
                            width: '30%',
                            type: 'date',
                            create: false,
                            edit: false
                        }
                    }
                });

                //Load person list from server
                $('#PeopleTableContainer').jtable('load');

            });

        </script>

    </body>
</html>