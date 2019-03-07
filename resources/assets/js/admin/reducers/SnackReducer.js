export const SnackReducer = (state = [], action) => {
    switch (action.type) {
        case 'SNACKS-ERROR':
            var errors = [];
            for (var key in action.payload) {
                action.payload[key].map((e)=>{
                    errors.push(
                        {
                            message: e,
                            variant: 'error'
                        }
                    );
                });
            }
            return errors;
        case 'TOKEN': return [{ variant: 'success', message: 'خوش آمدید' }];
        case 'LOGOUT': return [{ variant: 'success', message: 'به سلامت' }];
        case 'STORE-POST': return [{ variant: 'success', message: 'مطلب با موفقیت افزوده شد' }];
        case 'ALERT': return [{variant: 'success', message: 'loaded'}]
        case 'ERR':
            let errors = action.payload.response.data.errors;
            let status = action.payload.response.status;

            switch (status) {
                case 500:
                    return [{variant: 'error', message:'خطای سرور'}];
                default:
                    let messages = [];
                    let keys = Object.keys(errors);
                    keys.forEach(function(key) {
                        errors[key].forEach(function (err) {
                            messages.push({ variant: 'warning', message: err });
                        });
                    });
                    // ["default","error","success","warning","info"].
                    return messages;
            }
        default:
            return [];
    }
}