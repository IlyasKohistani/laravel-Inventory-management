
        const reviewTable = document.getElementById('dataTable');

        // register desired plugins...
        FilePond.registerPlugin(
            // validates the size of the file...
            FilePondPluginFileValidateSize,
            // validates the file type...
            FilePondPluginFileValidateType,
        );

        // Filepond: With Validation
        const pond = FilePond.create(document.querySelector('.with-validation-filepond'), {
            allowImagePreview: false,
            allowMultiple: false,
            allowFileEncode: false,
            required: true,
            acceptedFileTypes: ['application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ],
            fileValidateTypeDetectType: (source, type) => new Promise((resolve, reject) => {
                // Do custom type detection here and return with promise
                resolve(type);
            })
        });

        // 'addfile''
        pond.on('addfile', (error, file) => {
            if (error) {
                reviewTable.innerHTML = '';
                return;
            }
            readJSON(file.file, renderDataTable);

        });
        // 'removefile''
        pond.on('removefile', (error, file) => {
            reviewTable.innerHTML = '';
        });

        //render records table for review
        function renderDataTable(data) {
            reviewTable.innerHTML = generateDataTable(data);
        }

        //generate records table for review
        function generateDataTable(data) {
            var table_output =
                '<div class="card"><div class="card-header"><h4 class="card-title">Review Records</h4></div>\
                <div class="card-content"><div class="card-body"><div class="table-responsive"><table class="table table-bordered table-hover mb-0">';

            const heading_length = data[0].length ?? 0;
            for (var row = 0; row < data.length; row++) {
                if (data[row].length > 0) {
                    table_output += '<tr>';
                    for (var cell = 0; cell < heading_length; cell++) {

                        if (row == 0) {
                            table_output += '<th>' + data[row][cell] + '</th>';

                        } else {

                            table_output += '<td>' + (data[row][cell] ?? '-') + '</td>';

                        }

                    }
                    table_output += '</tr>';
                }

            }

            table_output += '</table></div></div></div></div>';
            return table_output;
        }

        //read records from excel file
        function readJSON(file, callback) {
            var reader = new FileReader();
            reader.readAsArrayBuffer(file);
            reader.onload = function(event) {
                var data = new Uint8Array(reader.result);
                var work_book = XLSX.read(data, {
                    type: 'array'
                });

                var sheet_name = work_book.SheetNames;

                var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {
                    header: 1
                });

                if (sheet_data.length > 0) {
                    callback(sheet_data);
                }
            }
        }

        document.getElementById('form').addEventListener('submit', function(e) {
            e.preventDefault();
            config.loader.show();
            var formData = new FormData();
            formData.append("file", pond.getFile().file);
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: config.routes.import,
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    config.loader.hide();
                    config.messages.success('Records imported successfully!');
                    pond.removeFiles();
                },
                error: function(response, error) {
                    config.loader.hide();
                    config.messages.error(config.func.customError(response));
                }
            });
        });