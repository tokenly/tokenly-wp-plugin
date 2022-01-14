import * as React from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';

interface PromiseLinkProps {
	id: number,
}

export default function PromiseLink( props: PromiseLinkProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	return (
		<span>
			<span>№ </span>
			<b>
				<a href={ `${adminPageUrl}${namespace}-token-promise-show&promise=${ props.id }` }>
					{ props.id }
				</a>
			</b>
		</span>
	);
}
 

