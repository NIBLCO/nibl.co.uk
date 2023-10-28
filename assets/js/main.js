import '../css/main.css';

const showElem = el => {
    el.classList.remove('hidden');
    el.classList.add('block');
}

const hideElem = el => {
    el.classList.remove('block');
    el.classList.add('hidden');
}

const getDataAttribute = (el, attrName) => el.getAttribute(`data-${attrName}`);

const copyToClipboard = (function initClipboardText() {
    const clipboardLabel = document.createElement('label');
    const textarea = document.createElement('textarea');
    // Move it off-screen.
    textarea.id = 'clipboard';
    clipboardLabel.htmlFor = 'clipboard';
    clipboardLabel.innerHTML = 'Clipboard';
    clipboardLabel.classList.add('sr-only');
    clipboardLabel.style.cssText = 'position: absolute; left: -99999em';
    textarea.style.cssText = 'position: absolute; left: -99999em';

    // Set to readonly to prevent mobile devices opening a keyboard when
    // text is .select()'ed.
    textarea.setAttribute('readonly', true);

    document.body.appendChild(clipboardLabel);
    document.body.appendChild(textarea);

    return function setClipboardText(text) {
        textarea.value = text;

        // Check if there is any content selected previously.
        const selected = document.getSelection().rangeCount > 0 ?
            document.getSelection().getRangeAt(0) : false;

        // iOS Safari blocks programmatic execCommand copying normally, without this hack.
        // https://stackoverflow.com/questions/34045777/copy-to-clipboard-using-javascript-in-ios
        if (navigator.userAgent.match(/ipad|ipod|iphone/i)) {
            const editable = textarea.contentEditable;
            textarea.contentEditable = true;
            const range = document.createRange();
            range.selectNodeContents(textarea);
            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);
            textarea.setSelectionRange(0, 999999);
            textarea.contentEditable = editable;
        } else {
            textarea.select();
        }

        try {
            const result = document.execCommand('copy');

            // Restore previous selection.
            if (selected) {
                document.getSelection().removeAllRanges();
                document.getSelection().addRange(selected);
            }

            return result;
        } catch (err) {
            console.error(err);
            return false;
        }
    };
})();

const formatSingleXDCCMsg = (botName, botPack) => {
    return `/msg ${botName} xdcc send #${botPack}`;
}

const formatMultilineXDCCMsg = selectedData => {
    let messages = [];
    selectedData.forEach(el => {
        messages.push(`/msg ${el.bot} xdcc batch ${el.items.join(',')}`);
    })

    return messages.join('\n');
}

const copyTextFromButton = selectedButton => {
    const botName = getDataAttribute(selectedButton, 'botname'),
        botPack = getDataAttribute(selectedButton, 'botpack'),
        buttons = [...document.getElementsByClassName('copy-data')],
        formattedSingleMsg = formatSingleXDCCMsg(botName, botPack);

    try {
        copyToClipboard(formattedSingleMsg);
        buttons.forEach(el => {
            el.classList.remove('bg-gray-300');
            el.classList.add('bg-gray-100');
            el.classList.add('cursor-not-allowed')
        });
        selectedButton.innerHTML = 'Copied';
    } catch (err) {
        selectedButton.innerHTML = 'Error';
    }

    setTimeout(() => {
        buttons.forEach(el => {
            el.classList.add('bg-gray-300');
            el.classList.remove('bg-gray-100');
            el.classList.remove('cursor-not-allowed')
        });
        selectedButton.innerHTML = 'Copy';
    }, 1000);
}

const toggleMobileMenu = () => {
    const mobileMenu = document.getElementById('mobile-menu'),
        menuCloseIco = document.getElementById('menu-close'),
        menuOpenIco = document.getElementById('menu-open');

    if (mobileMenu.classList.contains('hidden')) {
        showElem(mobileMenu);
        hideElem(menuOpenIco);
        showElem(menuCloseIco);
    } else {
        hideElem(mobileMenu);
        hideElem(menuCloseIco);
        showElem(menuOpenIco);
    }
}

const toggleBatchMode = () => {
    const enableCopyAsBatchBtn = document.getElementById('enable-copy-as-batch'),
        disableCopyAsBatchBtn = document.getElementById('disable-copy-as-batch'),
        clearSelectedBatchBtn = document.getElementById('clear-selected-batch'),
        copyBatch = document.getElementById('copy-as-batch'),
        copyDataBtns = [...document.getElementsByClassName('copy-data')],
        copyBatchCheckboxes = [...document.getElementsByClassName('batch-copy-checkbox')],
        copyBatchInputs = [...document.getElementsByClassName('form-tick')];

    if (enableCopyAsBatchBtn.classList.contains('hidden')) {
        enableCopyAsBatchBtn.classList.remove('hidden');
        disableCopyAsBatchBtn.classList.add('hidden');
        clearSelectedBatchBtn.classList.add('hidden');
        copyBatch.classList.add('hidden');
        copyDataBtns.forEach(el => el.classList.remove('hidden'));
        copyBatchCheckboxes.forEach(el => {
          el.classList.remove('hidden');
          el.classList.add('hidden');
        });
        copyBatchInputs.forEach(el => el.checked = false);
    } else {
        enableCopyAsBatchBtn.classList.add('hidden');
        disableCopyAsBatchBtn.classList.remove('hidden');
        clearSelectedBatchBtn.classList.remove('hidden');
        copyBatch.classList.remove('hidden');
        copyDataBtns.forEach(el => el.classList.add('hidden'));
        copyBatchCheckboxes.forEach(el => {
          el.classList.remove('hidden');
          el.classList.add('flex');
        });
    }
}

const copyTextAsBatch = () => {
    let selectedData = [];
    const copyBatch = document.getElementById('copy-as-batch'),
        copyBatchInputs = [...document.getElementsByClassName('form-tick')];

    copyBatchInputs.forEach(el => {
        const botName = getDataAttribute(el, 'botname'),
            botPack = getDataAttribute(el, 'botpack');

        let botIndex = selectedData.findIndex(data => data.bot === botName);
        if (botIndex === -1 && el.checked === true) {
            selectedData.push({'bot': botName, items: [botPack]});
        } else if (botIndex !== -1 && el.checked === true) {
            selectedData[botIndex]['items'].push(botPack);
        }
    });

    try {
        const formattedMultiMsg = formatMultilineXDCCMsg(selectedData);
        copyToClipboard(formattedMultiMsg);
        copyBatch.classList.remove('bg-gray-800');
        copyBatch.classList.add('bg-gray-600');
        copyBatch.innerHTML = 'Copied';
    } catch (err) {
        copyBatch.innerHTML = 'Error';
    }

    setTimeout(() => {
        copyBatch.classList.remove('bg-gray-600');
        copyBatch.classList.add('bg-gray-800');
        copyBatch.innerHTML = 'Copy selected';
    }, 1000);
}

const toggleDarkMode = () => {
  const head = document.documentElement;

  if (head.classList.contains('dark')) {
    head.classList.remove('dark');
    toggleDarkModeIcon(false);
    localStorage.setItem('darkMode', 'disabled');
  } else {
    head.classList.add('dark');
    toggleDarkModeIcon(true);
    localStorage.setItem('darkMode', 'enabled');
  }
}

const toggleDarkModeIcon = isDarkModeEnabled => {
  const lightModeIco = document.getElementById('light-mode-ico'),
    darkModeIco = document.getElementById('dark-mode-ico');

  if (!isDarkModeEnabled) {
    hideElem(lightModeIco);
    showElem(darkModeIco);
    return;
  }

  hideElem(darkModeIco);
  showElem(lightModeIco);
}

const shiftSelect = (lastChecked, currentChecked) => {
    let rows = document.querySelectorAll("div table tbody tr");
    
    let a = lastChecked.dataset.botpack;
    let a_name = lastChecked.dataset.botname;

    let b = currentChecked.dataset.botpack;
    let b_name = currentChecked.dataset.botname;

    let flag = false;

    for (let i = 0; i < rows.length; i++) {
        let children = rows[i].children[4] == undefined ? rows[i].children[3] : rows[i].children[4];
        let input = children.querySelector("label").querySelector("input");
        let botpack = input.dataset.botpack;
        let botname = input.dataset.botname;

        if ((botpack == a && botname == a_name) || (botpack == b && botname == b_name)) {
            flag = !flag;
        }

        if (flag) input.checked = true;
    }
}

var lastChecked;
document.addEventListener('click', event => {
    if (event.target.matches('.copy-data')) {
        event.preventDefault();
        copyTextFromButton(event.target);
    }

    if (event.target.matches('#clear-selected-batch')) {
      event.preventDefault();
      [...document.getElementsByClassName('form-tick')].forEach(el => el.checked = false);
    }

    if (event.target.matches('.mobile-menu-toggle')) {
        event.preventDefault();
        toggleMobileMenu();
    }

    if (event.target.matches('#enable-copy-as-batch') || event.target.matches('#disable-copy-as-batch')) {
        event.preventDefault();
        toggleBatchMode();
    }

    if (event.target.matches('#copy-as-batch')) {
        event.preventDefault();
        copyTextAsBatch();
    }

    if (event.target.matches('#toggle-dark-mode')) {
      event.preventDefault();
      toggleDarkMode();
    }

    if (event.target.matches(".form-tick")) {
        if (event.shiftKey) {
            let currentChecked = event.target;
            lastChecked !== null && shiftSelect(lastChecked, currentChecked);
        } else {
            lastChecked = event.target;
        }
    }
}, false);

(() => {
  toggleDarkModeIcon(
    localStorage.darkMode === 'enabled' ||
    (!('darkMode' in localStorage) &&
      window.matchMedia('(prefers-color-scheme: dark)').matches)
  );
})()
