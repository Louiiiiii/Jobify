const addMargin = document.body.clientHeight - document.querySelector('.card').clientHeight < 0 ? 
                        (document.body.clientHeight*0.1).toString() + 'px 0' : 
                        '0';
document.querySelector('body').style.margin = addMargin;