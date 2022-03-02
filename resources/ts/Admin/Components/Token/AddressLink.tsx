import * as React from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';

import {
	Button,
} from '@wordpress/components';

interface AddressLinkProps {
	id: string,
	label?: string,
	text?: boolean,
}

export default function AddressLink( props: AddressLinkProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	const title = props?.label ?? props.id;
	const url = `${adminPageUrl}${namespace}-token-address-show&address=${ props.id }`;
	if ( props.text ) {
		return (
			<b><span>{ title }</span></b>
		)
	}
	return (
		<Button
			isLink	
			href={ url }
		>
				{ title }
		</Button>
	);
}
 

