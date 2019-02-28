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
        default:
            return [];
    }
}