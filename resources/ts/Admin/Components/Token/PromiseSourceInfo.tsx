import * as React from 'react';
import { PromiseData } from '../../../Interfaces';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../Types';

import { 
	Flex,
} from '@wordpress/components';

interface PromiseSourceInfoProps {
	promise: PromiseData;
	sources: any; 
	loadingSources: boolean;
}

export default function PromiseSourceInfo( props: PromiseSourceInfoProps ) {
	const adminPageUrl = useInjection( TYPES.Variables.adminPageUrl );
	const namespace = useInjection( TYPES.Variables.namespace );
	
	function getPromiseSource( promiseItem: any ) {
		let address = promiseItem.source_id;
		const source = props.sources[ promiseItem.source_id ] ?? null;
		if ( source ) {
			address = source?.address?.label;
		}
		return address;
	}
	
	function sourceExists( promiseItem: any ) {
		const source = props.sources[ promiseItem.source_id ] ?? null;
		if ( source ) {
			return true;
		} else {
			return false;
		}
	}

	return (
		<Flex>
			<div>
				<span>Source: </span>
				<span>
					{ sourceExists( props.promise )
						?	<a href={`${adminPageUrl}${namespace}-token-source-show&source=${props.promise.source_id}`}>
								<b>{ getPromiseSource( props.promise ) }</b>
							</a>
						: 	<span><b>{ props.promise.source_id }</b></span>
					}
				</span>
			</div>
		</Flex>
	);
}
 

