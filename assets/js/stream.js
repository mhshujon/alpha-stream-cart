document.addEventListener('DOMContentLoaded', function() {
    const localVideo = document.getElementById('local-video');
    const startButton = document.getElementById('start-streaming');
    const stopButton = document.getElementById('stop-streaming');
    let mediaStream = null;
    let rtmpClient = null;

    // Capture media from user's webcam
    async function startVideoCapture() {
        try {
            mediaStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
            localVideo.srcObject = mediaStream;

            // Create an RTMP client
            rtmpClient = new RTMPClient();
            // Connect to Facebook Live RTMP endpoint
            const facebookStreamUrl = 'rtmps://live-api-s.facebook.com:443/rtmp/1130092112453518?s_bc=1&s_bed=1&s_bl=1&s_bsr=1&s_psm=1&s_pub=1&s_sw=0&s_tids=1&s_vt=api-s&a=Aby_YQCeVYG37sO2'
            rtmpClient.open(facebookStreamUrl);

            // Push the webcam stream to Facebook Live
            rtmpClient.publish(mediaStream);
        } catch (err) {
            console.error('Error starting WebRTC or RTMP: ', err);
        }
    }

    startButton.addEventListener('click', startVideoCapture);

    stopButton.addEventListener('click', function() {
        if (mediaStream) {
            let tracks = mediaStream.getTracks();
            tracks.forEach(track => track.stop());
            rtmpClient.close();
        }
    });
});