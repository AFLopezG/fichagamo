var device;
function setup(device) {
    return device.open()
    .then(() => device.selectConfiguration(1))
    .then(() => device.claimInterface(0))
}

function print() {
    var string = document.getElementById('myelement').value + '\n';
    var encoder = new TextEncoder();
    var data = encoder.encode(string);
    device.transferOut(1, data)
    .catch(error => { console.log(error); })
}

function connectAndPrint() {
    if (device == null) {
        navigator.usb.requestDevice({ filters: [{ vendorId: 1046 }] })
        .then(selectedDevice => {
            device = selectedDevice;
            console.log(device);
            return setup(device);
        })
        .then(() => print())
        .catch(error => { console.log(error); })
    }
    else
        print();
}

navigator.usb.getDevices()
.then(devices => {
    if (devices.length > 0) {
        device = devices[0];
        return setup(device);
    }
})
.catch(error => { console.log(error); });

