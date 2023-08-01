const puppeteer = require('puppeteer');

function screenShot_byURL(url) {
    try {
        (async () => {
            const browser = await puppeteer.launch({headless:'new'});
            const page = await browser.newPage();
            //await page.goto('https://www.similarweb.com/website/'+url+'/#overview', {waitUntil: 'networkidle0'});
            await page.goto('https://www.similarweb.com/website/'+url+'/#overview');
            //using DOM select className for get part html 
            const data = await page.waitForSelector('.engagement-list__item-value');
            const total_visits = await (await data.getProperty("innerText")).jsonValue();
            browser.close();
            //returen total vistors
            return console.log(total_visits);
        })();
    } catch (e) {
        return console.log("-");
    }
}
const url = process.argv[2];
screenShot_byURL(url);
