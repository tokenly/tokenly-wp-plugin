import * as React from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';

interface SourceLinkProps {
	id: string,
	label?: string,
	text?: boolean,
}

export default function SourceLink( props: SourceLinkProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	const title = props?.label ?? props.id;
	const url = `${adminPageUrl}${namespace}-token-source-show&source=${ props.id }`;
	if ( props.text ) {
		return (
			<b><span>{ title }</span></b>
		)
	}
	return (
		<b><a href={ url }>{ title }</a></b>
	);
}
 

