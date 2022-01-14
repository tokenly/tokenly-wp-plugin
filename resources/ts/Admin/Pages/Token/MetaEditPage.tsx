import * as React from 'react';
import { useState } from 'react';
import { TokenMetaData } from '../../../Interfaces';
import MetaEditForm from '../../Components/Token/MetaEditForm';
import eventBus from './../../../EventBus';

import { 
	PanelRow,
} from '@wordpress/components';

import { 
	Fragment,
} from '@wordpress/element';

interface MetaEditPageData {
	meta: TokenMetaData;
	extra: any;
}

interface MetaEditPageProps {
	pageData: MetaEditPageData;
}

export default function MetaEditPage( props: MetaEditPageProps ) {
	const asset = props.pageData.meta?.asset ?? '';
	let extra = Object.assign( [], props.pageData.meta?.extra );
	if ( extra && Array.isArray( extra ) ) {
		extra = extra.filter( function ( item: any ) {
			return item != null;
		} );
	} else {
		extra = [];
	}

	const [ editData, setEditData ] = useState<any>( {
		asset: asset,
		extra: extra,
	} );

	function onEditDataChange( newData: any ) {
		newData.extra = newData.extra.filter( function ( item: any ) {
			return item != null;
		} );
		setEditData( newData );
		eventBus.dispatch( 'postDataUpdated', newData );
	}
	
	return (
		<Fragment>
			<PanelRow>
				<MetaEditForm
					editData={ editData }
					onChange={ onEditDataChange }
				/>
			</PanelRow>
		</Fragment>
	);
}
