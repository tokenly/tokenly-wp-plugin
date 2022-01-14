import * as React from 'react';

import { 
	SelectControl,
} from '@wordpress/components';

interface TransactionTypeFieldProps {
	type: string;
	onChange: any;
}

export default function TransactionTypeField( props: TransactionTypeFieldProps ) {
	return (
		<SelectControl
			label="Transaction Type"
			value={ props.type }
			options={ [
				{ label: 'Debit' , value: 'debit' },
				{ label: 'Credit'  , value: 'credit'  },
			] }
			onChange={ props.onChange }
		/>
	);
}
 

