import * as React from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';

import { 
	Flex,
} from '@wordpress/components';

interface SourceInfoProps {
	source: any;
}

export default function SourceInfo( props: SourceInfoProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );

	return (
		<Flex style={ { width: '100%', alignItems: 'center' } }>
			<div style={ { flex: 1 } }>
				<div>
					<span>Type: </span>
					<b>{ props.source?.type }</b>
				</div>
				<div>
					<span>Address: </span>
					<b>
						<a 
							href={ `${adminPageUrl}${namespace}-token-address-show&id=${props.source?.address_id}` }>
								{ props.source?.address?.label ?? props.source?.address_id }
						</a>
					</b>
				</div>
				<div>
					<span>Assets (whitelisted): </span>
					<b>{ props.source?.assets ?? 'all' }</b>
				</div>
			</div>
		</Flex>
	);
}
