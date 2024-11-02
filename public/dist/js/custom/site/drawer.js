const setup = () => {
    return {
        isSidebarOpen: false,
        currentSidebarTab: null,
        isSettingsPanelOpen: false,
        isSubHeaderOpen: false,
        watchScreen() {
            if (window.innerWidth <= 1024) {
                this.isSidebarOpen = false
            }
        },
    }
}
// loading time
$(document).ready(function () {
    document.querySelectorAll('.hideme').forEach(divs => {
        divs.classList.toggle('hidden')
    });
});
