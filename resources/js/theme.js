
export const toDarkMode = () => {
    localStorage.theme = 'dark';
    window.updateTheme();
}
 
export const toLightMode = () => {
    localStorage.theme = 'light';
    window.updateTheme();
}
 
export const toSystemMode = () => {
    localStorage.theme = 'system';
    window.updateTheme();
}




switch(localStorage.theme) {
    case 'system':
        if (window.matchMedia('(prefers-color-scheme: dark').matches) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        document.documentElement.setAttribute('color-theme', 'system');
        break;
    case 'dark':
        document.documentElement.classList.add('dark');
        document.documentElement.setAttribute('color-theme', 'dark');
        break;
    case 'light':
        document.documentElement.classList.remove('dark');
        document.documentElement.setAttribute('color-theme', 'light');
        break;
}