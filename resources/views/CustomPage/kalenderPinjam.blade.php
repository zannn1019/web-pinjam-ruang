<div id='calendar'></div>
<script>
    // open-admin-kalender.js

    $(document).ready(function() {
        // Fungsi untuk mendapatkan data ruang pinjam
        function getRuangPinjam() {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    type: "GET",
                    url: "/admin/get-ruang-pinjam-data",
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);
                        resolve(response);
                    },
                    error: function(error) {
                        reject(error);
                    }
                });
            });
        }

        // Fungsi untuk menginisialisasi atau memperbarui kalender dengan data
        function initializeCalendar() {
            getRuangPinjam().then(function(eventData) {
                console.log(eventData.data);
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    height: 600,
                    aspectRatio: 2,
                    events: eventData.data
                });
                calendar.render();
            }).catch(function(error) {
                console.error('Error getting ruang pinjam data:', error);
            });
        }

        // Memanggil fungsi inisialisasi kalender saat dokumen siap
        initializeCalendar();
    });
</script>
