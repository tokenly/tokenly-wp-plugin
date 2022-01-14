import * as React from 'react';

import { 
	// @ts-ignore
	Modal,
	Flex,
	Button,
} from '@wordpress/components';

interface ConfirmModalProps {
	title: string;
	subtitle: string;
	onRequestClose: any;
	onChoice: any;
}

export default function AppConfirmModal( props: ConfirmModalProps ) {
	function onRequestClose() {
		props.onRequestClose();
	}

	function onChoice( choice: string ) {
		props.onChoice( choice );
	}
	
	return (
		<Modal title={ props.title } onRequestClose={ onRequestClose }>
			<div>{ props.subtitle } </div>
			<Flex
				justify="flex-start"
				style={ { marginTop: '12px' } }	
			>
				<Button
					isSecondary
					onClick={ () => {
						onChoice( 'accept' );
					} }
				>
					Accept
				</Button>
				<Button
					isSecondary
					onClick={ () => {
						onChoice( 'deny' );
					} }
				>
					Deny
				</Button>
			</Flex>
		</Modal>
	);
}
