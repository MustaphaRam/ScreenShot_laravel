const puppeteer = require('puppeteer');

function screenShot_byURL(url, name_img) {
    (async () => {
        const browser = await puppeteer.launch();
        const page = await browser.newPage();
        await page.setViewport({width: 1080, height: 900});
        await page.goto(url, { waitUntil: 'networkidle2' });
        await page.screenshot({ path: 'images/'+name_img });

        await browser.close();
    })();
    return console.log(name_img);
}

const url = process.argv[2];
const name_img = process.argv[3];
screenShot_byURL(url, name_img);